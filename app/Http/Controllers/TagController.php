<?php

namespace App\Http\Controllers;


use App\Models\Action;
use App\Models\Message;
use App\Models\Question;
use App\Models\Response;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $apiTagController;

    public function __construct(\App\Http\Controllers\Api\TagController $apiTagController)
    {
        $this->apiTagController = $apiTagController;
    }

    public function create(Request $request, Question $question)
    {
        $this->authorize('create', [Tag::class, $question]);
        $user = $request->user();
        return view('tags.create', compact('question', 'user'));
    }

    public function store(Question $question, Request $request)
    {
        $this->authorize('create', [Tag::class, $question]);
        $this->apiTagController->doCreate($request->user(), $question, $request->input('name'));
        return redirect('questions/' . $question->id);
    }

    public function show(Request $request, Tag $tag)
    {
        $responses = Response::whereHas('actions', function ($query) use ($tag) {
            $query->where('tag_id', $tag->id);
        })->inRandomOrder()->limit(20)->get();
        $question = $tag->question;
        $user = $request->user();
        return view('tags.show', compact('tag', 'responses', 'question', 'user'));
    }

    public function edit(Request $request, Tag $tag)
    {
        $this->authorize('update', $tag);
        $question = $tag->question;
        $user = $request->user();
        return view('tags.edit', compact('question', 'tag', 'user'));
    }

    public function update(Tag $tag, Request $request)
    {
        $this->authorize('update', $tag);
        $this->validate($request, [
            'name' => 'required',
        ]);
        $tag->name = $request->input('name');
        $tag->save();
        return redirect('questions/' . $tag->question->id);
    }

    public function delete(Request $request, Tag $tag)
    {
        $this->authorize('delete', $tag);
        $question = $tag->question;
        $tag->actions()->delete();
        $tag->delete();
        $request->user()->refreshScore();
        return redirect('questions/' . $question->id);
    }

    public function showDelete(Tag $tag)
    {
        $this->authorize('delete', $tag);
        $question = $tag->question;
        return view('tags.delete', compact('question', 'tag'));
    }

    public function showInject(Tag $tag)
    {
        $this->authorize('inject', $tag);
        $question = $tag->question;
        $customTags = Tag::where('question_id', $tag->question_id)->whereNotNull('user_id')->orderBy('name')->get();
        return view('tags.inject', compact('customTags', 'question', 'tag'));
    }

    public function doInject(Request $request, Tag $tag)
    {
        $this->authorize('inject', $tag);
        $question = $tag->question;
        $customTags = $request->input('customTags');
        $customTagNames = [];
        $userIds = [];
        $actionIds = [];
        foreach ($customTags as $customTagId) {
            $actionIds = array_merge($actionIds, Action::where('tag_id', $customTagId)->pluck('id')->toArray());
            Action::where('tag_id', $customTagId)->update(['updated_at' => Carbon::now(), 'tag_id' => $tag->id]);
            $customTag = Tag::find($customTagId);
            $customTagNames[] = $customTag->name;
            $userIds[] = $customTag->user_id;
            $customTag->delete();
        }
        $customTagNames = array_unique($customTagNames);
        $userIds[] = 1;
        $userIds = array_unique($userIds);
        $tagNames = array_map(function ($name) { return "\"*$name*\""; }, $customTagNames);
        $tagNames = implode(", ", $tagNames);
        foreach ($userIds as $userId) {
            $message = new Message();
            $message->title = 'Tag "' . $tag->name .'" pour la question ' . $tag->question_id;
            $message->content = "Bonjour,

Concernant la question $tag->question_id \"**$question->text**\", vous étiez plusieurs à avoir créé des tags comme $tagNames.

Nous avons donc créé un tag commun \"**$tag->name**\" qui est désormais visible pour toute la communauté.

Pour accélérer la convergence (du mécanisme qui compare les différentes annotations sur chaque réponse), nous avons 
remplacé vos tags personnels cités plus haut par le nouveau tag. Dans le cas où cela ne vous conviendrait pas, il est 
tout à fait possible de revenir en arrière et de conserver votre tag personnel en plus du tag commun 
(nous écrire dans ce cas).

Merci pour ces suggestions qui améliorent la qualité du travail commun.

Bonnes annotations,

L'équipe grandeannotation.fr (pour nous joindre : `grandeannotation@gmail.com`)";
            $message->user_id = $userId;
            $message->save();
        }
        $message = new Message();
        $message->title = 'Tag "' . $tag->name .'" pour la question ' . $tag->question_id . ' // Actions concernées';
        $message->content = implode("\n\n", $actionIds);
        $message->user_id = 1;
        $message->save();
        // Do it
        return redirect('/questions/' . $tag->question_id);
    }
}
