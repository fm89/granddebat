<template>
    <div>
        <div v-if="user != null && user.score == level[0] && user.score > 0" class="alert alert-success mb-3">
            <p>
                <b>Félicitations !</b> Grâce à vos {{ level[0] }} annotations, vous venez de passer au niveau
                <b>{{ level[2] }}</b>. Continuez sur cette lancée pour aider la communauté à donner du sens au débat ;
                et aussi pour gravir les échelons !
            </p>
        </div>
        <div v-if="showEasyHelp()" class="alert alert-info mb-3">
            <p>Lisez l'intitulé de la question et la réponse apportée par un contributeur ci-dessous.</p>
            <p>Déterminez la ou les catégories qui correspondent le mieux au texte. Cochez-les puis validez.</p>
            <p>Si le texte vous semble hors sujet ou ne pas contenir de réponse à la question, cliquez sur la croix
                grise.</p>
        </div>
        <div v-if="showBulbHelp()" class="alert alert-warning mb-3">
            <p>
                Si le texte vous semble particulièrement riche, argumenté ou étayé, classifiez-le puis utilisez le
                bouton jaune "<b>marquer l'idée</b>". Ces textes de qualité seront ensuite regroupés par thématique
                afin de pouvoir être transmis aux entités concernées.
            </p>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div v-if="user == null && question.status === 'open'">
                    <div class="alert alert-danger">
                        <a href="/register">Créez votre compte</a> ou <a href="/login">connectez-vous</a> pour
                        créer vos propres catégories, enregistrer votre catégorisation de cette contribution et
                        aider la communauté à donner du sens au débat !
                        <b>Vos annotations se sont pas enregistrées si vous n'êtes pas connecté.</b>
                    </div>
                    <br/>
                </div>
                <div v-if="previousQuestion != null">
                    <b>{{ previousQuestion.text }}</b>
                    <span v-if="previousResponse != null">{{ previousResponse.value }}</span>
                    <br/>
                </div>
                <b>{{ question.text }}</b>
                <blockquote class="quote1">
                    <p class="quotation">
                        <span v-for="line in formattedText()">{{ line }}<br/></span>
                    </p>
                    <footer>
                        <a :href="'/proposals/' + response.proposal_id">contribution</a>
                    </footer>
                </blockquote>
                <br/>
                <div v-if="(question.status === 'open') || (user !== null && user.role === 'admin')">
                    <toggle-button v-for="(tag, index) in tags" :tag="tag" :key="index" @tagToggled="onTagToggled(tag.id)"></toggle-button>
                    <button class="btn btn-light create-btn" data-toggle="modal" data-target="#modalCreate"
                       :disabled="user == null">
                        <i class="fa fa-plus"></i> Créer
                    </button>
                    <br/><br/>
                    <button v-if="user != null" class="btn btn-primary mybtn" @click="send('save')" :disabled="tagIds().length == 0">
                        <i class="fa fa-check"></i>
                        <span class="d-none d-sm-inline">Valider</span>
                    </button>
                    <button v-if="user != null" class="btn btn-secondary mybtn" @click="send('noanswer')" :disabled="tagIds().length > 0">
                        <i class="fa fa-times-circle"></i>
                        <span class="d-none d-sm-inline">Sans réponse</span>
                    </button>
                    <button v-if="showBulb()" class="btn btn-warning mybtn" @click="send('lightbulb')">
                        <i class="fa fa-lightbulb"></i>
                        <span class="d-none d-sm-inline">Marquer l'idée</span>
                    </button>
                    <button class="btn btn-light mybtn" @click="loadNext()" style="float: right;">
                        <i class="fa fa-step-forward"></i>
                        <span class="d-none d-sm-inline">Suivante</span>
                    </button>
                </div>
                <div v-else>
                    <div class="alert alert-warning">
                        Les catégories par défaut pour cette question sont actuellement en cours de préparation.
                        Il n'est donc pas possible de participer à l'annotation des textes pour le moment.
                        Vous pouvez continuer à lire des réponses aléatoires en cliquant sur "Suivante" ou
                        en apprendre plus sur le processus de création des catégories dans la <a href="/faq">FAQ</a>.
                    </div>
                    <a class="btn btn-light" @click="loadNext()" style="float: right;">
                        <i class="fa fa-btn fa-step-forward"></i>
                        <div class="d-none d-sm-inline">Suivante</div>
                    </a>
                </div>
            </div>
        </div>
        <modal-create-tag :question="question" :can-bulb="showBulb()" @tagCreated="onTagCreated"></modal-create-tag>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tags: this.initialTags,
                key: this.initialKey,
                user: this.initialUser,
                response: this.initialResponse,
                previousResponse: this.initialPreviousResponse,
                level: [0, 'info', 'Piou Piou'],
            }
        },
        props: {
            question: {
                type: Object,
                required: true,
            },
            previousQuestion: {
                type: Object,
            },
            initialTags: {
                type: Array,
                required: true,
            },
            initialKey: {
                type: String,
                required: true,
            },
            initialUser: {
                type: Object,
            },
            initialResponse: {
                type: Object,
                required: true,
            },
            initialPreviousResponse: {
                type: Object,
            },
        },
        methods: {
            formattedText() {
                return this.response.value.split("\n");
            },
            showEasyHelp() {
                return (this.user !== null) && (this.user.score < 10) && (this.question.status === 'open');
            },
            showBulb() {
                return (this.user !== null) && (this.user.score >= 50);
            },
            showBulbHelp() {
                return this.showBulb() && (this.user.score < 60);
            },
            onTagToggled(tagId) {
                $.each(this.tags, function (index, tag) {
                    if (tag.id === tagId) {
                        tag.checked = !tag.checked;
                    }
                });
            },
            onTagCreated(tag) {
                tag.checked = true;
                this.tags.push(tag);
                $('#modalCreate').modal('hide');
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
            async send(message) {
                let result = await $.ajax({
                    url: '/api/responses',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        action: message,
                        key: this.key,
                        tags: this.tagIds(),
                    }
                });
                this.user.score = result.score;
                this.key = result.key;
                this.previousResponse = result.previousResponse;
                this.response = result.response;
                this.level = result.level;
                $('#myScore')[0].className = 'badge badge-pill badge-' + result.level[1];
                $('#myScore')[0].innerHTML = '' + result.score + ' - ' + result.level[2];
                this.resetScreen();
            },
            async loadNext() {
                // Retrieve next response data
                let result = await $.ajax({
                    url: '/api/questions/' + this.question.id + '/next',
                    type: 'GET',
                    data: {},
                });
                this.key = result.key;
                this.previousResponse = result.previousResponse;
                this.response = result.response;
                this.resetScreen();
            },
            resetScreen() {
                // Trick to replay the CSS animation
                $('blockquote').toggleClass('quote1');
                $('blockquote').toggleClass('quote2');
                // Uncheck all tags
                this.tags.forEach(function (tag) {
                    tag.checked = false;
                });
                // Send user back to top of screen so he can see the next response
                document.documentElement.scrollTo(0, 1);
            }
        }
    }
</script>

<style>
    @keyframes example1 {
        from {opacity: 0;}
        to {opacity: 1;}
    }
    @keyframes example2 {
        from {opacity: 0;}
        to {opacity: 1;}
    }
    .quote1 {
        animation-name: example1;
        animation-duration: 1s;
    }
    .quote2 {
        animation-name: example2;
        animation-duration: 1s;
    }
    .mybtn {
        padding: 8px 14px;
    }
    @media only screen
    and (max-width : 576px) {
        .mybtn {
            padding: 12px 18px;
        }
    }
    .quotation {
        margin: 5px;
    }
    .create-btn {
        border-radius: 20px;
        margin-right: 10px;
        margin-bottom: 10px;
    }
    .mybtn > .fa {
        font-size: 1.33em;
        vertical-align: -10%;
    }
</style>