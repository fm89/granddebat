import json
import os
import requests
import pandas as pd

download = False
base_url = 'http://opendata.auth-6f31f706db6f4a24b55f42a6a79c5086.storage.sbg5.cloud.ovh.net/2019-02-06/'
files = [
    'DEMOCRATIE_ET_CITOYENNETE.json',
    'LA_TRANSITION_ECOLOGIQUE.json',
    'LA_FISCALITE_ET_LES_DEPENSES_PUBLIQUES.json',
    'ORGANISATION_DE_LETAT_ET_DES_SERVICES_PUBLICS.json']

if download:
    for file in files:
        print("Downloading file {}".format(file))
        r = requests.get(base_url + file)
        with open(file, 'wb') as f:
            f.write(r.content)
        print("Downloaded file {}".format(file))

proposals = []
responses = []
for file in files:
    print("Processing file {}".format(file))
    with open(file, 'r', encoding='utf-8') as f:
        data = json.load(f)
        for proposal in data:
            reference = proposal['reference']
            debate_id = int(reference[0])
            proposal_id = int(reference[2:])
            p_id = 1000000 * debate_id + proposal_id
            if proposal['trashed']:
                continue
            published_at = proposal['publishedAt']
            if not published_at:
                # A few proposals have not publishedAt date so we discard them since we are unsure whether
                # they are really published
                continue
            title = proposal['title']
            author_id = proposal['authorId']
            proposals.append([p_id, published_at, title, debate_id, author_id])
            for response in proposal['responses']:
                question_id = int(response['questionId'])
                if question_id == 160 or question_id == 206 or question_id == 207:
                    # These 3 multiple choice questions allow users to input raw text
                    value_json = json.loads(response['value'])
                    value_labels = ', '.join(value_json['labels'])
                    if value_labels:
                        responses.append([1000000 * (1000 + question_id) + proposal_id, value_labels, 1000 + question_id, p_id])
                    if value_json['other']:
                        # If the user entered some custom text, we separate it from the official labels
                        responses.append([1000000 * question_id + proposal_id, value_json['other'].replace('\0', ''), question_id, p_id])
                else:
                    value = response['formattedValue']
                    if value:
                        responses.append([1000000 * question_id + proposal_id, value.replace('\0', ''), question_id, p_id])

proposals = pd.DataFrame(proposals, columns=['id', 'published_at', 'title', 'debate_id', 'author_id'])
responses = pd.DataFrame(responses, columns=['id', 'value', 'question_id', 'proposal_id'])
proposals.drop_duplicates(subset=None, keep='first', inplace=True)
responses.drop_duplicates(subset=None, keep='first', inplace=True)
proposals.to_csv('proposals.csv', ';', index=False, header=True, encoding='utf-8')
responses.to_csv('responses.csv', ';', index=False, header=True, encoding='utf-8')
