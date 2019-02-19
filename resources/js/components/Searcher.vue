<template>
    <div class="row">
        <div class="col-lg-5 mb-3">
            <div class="form-group">
                <label for="text" class="control-label">Texte à chercher</label>
                <input type="text" name="text" id="text" class="form-control" v-model="text"/>
            </div>
            <div class="form-group">
                <label for="min_length">Longueur minimale de la réponse ({{ min_length}} caractère(s))</label>
                <input type="range" class="custom-range" min="0" max="300" step="10" id="min_length" v-model="min_length">
            </div>
            <div v-if="question.status === 'open'">
                <div class="form-group">
                    <label for="text" class="control-label">Catégories affectées (et)</label>
                </div>
                <div>
                    <toggle-button v-for="(tag, index) in tags" :tag="tag" :key="index"
                                   @tagToggled="onTagToggled(tag.id)"></toggle-button>
                </div>
            </div>
            <br/>
            <button class="btn btn-primary" @click="search()">
                <i class="fa fa-search"></i> Rechercher
            </button>
            <a class="btn btn-primary" :href="downloadLink()">
                <i class="fa fa-download"></i> Télécharger
            </a>
        </div>
        <div class="col-lg-7">
            <b>{{ total_count == 0 ? 'Aucune réponse trouvée' : ('' + total_count + (total_count > 1 ? ' réponses trouvées' : ' réponse trouvée'))}}
            {{ total_count > 100 ? ' (100 au hasard affichées)' : '' }}</b><br/>
            <blockquote v-for="response in responses">
                <p class="quotation">
                    <span v-for='line in splitLines(response)'>{{ line }}<br/></span>
                </p>
                <footer>
                    <a :href="'/proposals/' + response.proposal_id">contribution</a>
                </footer>
            </blockquote>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                min_length: 0,
                total_count: 0,
                responses: [],
                tags: this.initialTags,
                text: "",
            }
        },
        props: {
            question: {
                type: Object,
                required: true,
            },
            initialTags: {
                type: Array,
                required: true,
            },
        },
        methods: {
            splitLines(response) {
                return response.value.split("\n");
            },
            onTagToggled(tagId) {
                $.each(this.tags, function (index, tag) {
                    if (tag.id === tagId) {
                        tag.checked = !tag.checked;
                    }
                });
            },
            tagIds() {
                let result = [];
                this.tags.forEach(function (tag) {
                    if (tag.checked) {
                        result.push(tag.id);
                    }
                });
                return result;
            },
            downloadLink() {
                let query = {
                    min_length: this.min_length,
                    question_id: this.question.id,
                    tags: this.tagIds(),
                    text: this.text,
                };
                let query_64 = Buffer.from(JSON.stringify(query)).toString("base64");
                return '/api/downloads/search/' + query_64;
            },
            async search() {
                let result = await $.ajax({
                    url: '/api/responses',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        min_length: this.min_length,
                        question_id: this.question.id,
                        tags: this.tagIds(),
                        text: this.text,
                    }
                });
                this.total_count = result.total_count;
                this.responses = result.samples;
            },
        }
    }
</script>

<style>
    .quotation {
        margin: 5px;
    }
</style>