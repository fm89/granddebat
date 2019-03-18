<template>
    <div>
        <div v-if="showLevel()" class="alert alert-success mb-3">
            <p>
                <b>Félicitations !</b> Grâce à vos {{ level[0] }} annotations, vous venez de passer au niveau
                <b>{{ level[2] }}</b>. Continuez sur cette lancée pour aider la communauté à donner du sens au débat ;
                et aussi pour gravir les échelons !
            </p>
        </div>
        <div v-if="showProgress()" class="alert alert-success mb-3">
            <p>
                <b>Félicitations !</b> Vous avez franchi la barre des {{ user.scores.total }} annotations.
                Continuez sur cette lancée pour aider la communauté à donner du sens au débat ;
                et aussi pour gravir les échelons !
            </p>
        </div>
        <div v-if="showEasyHelp()" class="alert alert-info mb-3">
            <p>1. Lisez l'intitulé de la question et la réponse apportée par un contributeur ci-dessous.</p>
            <p>2. Déterminez la ou les catégories qui correspondent le mieux au texte. Cochez-les puis validez.</p>
            <p>3. Si le texte vous semble hors sujet ou ne pas contenir de réponse à la question, cliquez sur la croix
                grise.</p>
            <p><b>Il ne s'agit pas de juger de l'utilité, de la faisabilité ou de la valeur des idées ou des opinions
                exprimées, mais uniquement de les classifier.</b></p>
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
                <div v-if="showWarningAccount()">
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
                        <a v-if="!demo" target="_blank" :href="'/proposals/' + response.proposal_id">
                            &ndash; {{ response.city + ', le ' + response.published_at }}
                        </a>
                    </footer>
                </blockquote>
                <br/>
                <div v-if="canTagQuestion()">
                    <div v-if="score() <= 24">
                        <b>Selon vous, quelles idées clefs résument le mieux ce qu'a voulu dire le répondant ?</b>
                        <br><br>
                    </div>
                    <toggle-button v-for="(tag, index) in tags" :tag="tag" :key="index"
                                   @tagToggled="onTagToggled(tag.id)"></toggle-button>
                    <button class="btn btn-light create-btn" data-toggle="modal" data-target="#modalCreate"
                            :disabled="user == null || loading">
                        <i class="fa fa-plus"></i>
                        <span>Créer</span>
                    </button>
                    <br/><br/>
                    <action-button ref="saveButton" v-if="user != null || demo" @clicked="sendSave"
                                   :disabled="tagIds().length == 0 || loading"
                                   :btnClass="'btn-primary'" :iconClass="'fa-check'" :text="'Valider'"></action-button>
                    <action-button ref="noanswerButton" v-if="user != null || demo" @clicked="sendNoanswer"
                                   :disabled="tagIds().length > 0 || loading"
                                   :btnClass="'btn-secondary'" :iconClass="'fa-times-circle'"
                                   :text="'Sans réponse'"></action-button>
                    <action-button v-if="showBulb()" @clicked="sendLightbulb"
                                   :disabled="loading"
                                   :btnClass="'btn-warning'" :iconClass="'fa-lightbulb'"
                                   :text="'Marquer l\'idée'"></action-button>
                    <action-button v-if="!demo" @clicked="loadNext"
                                   :disabled="tagIds().length > 0 || loading" :style="'float: right;'"
                                   :btnClass="'btn-light'" :iconClass="'fa-step-forward'"
                                   :text="user == null ? 'Lire une autre' : 'Passer'"></action-button>
                </div>
                <div v-if="!canTagQuestion()">
                    <div v-if="isPreparing()" class="alert alert-warning">
                        Les catégories par défaut pour cette question sont actuellement en cours de préparation.
                        Il n'est donc pas possible de participer à l'annotation des textes pour le moment.
                        Vous pouvez continuer à lire des réponses aléatoires en cliquant sur "Suivante" ou
                        en apprendre plus sur le processus de création des catégories dans la <a href="/faq">FAQ</a>.
                        En attendant, allez-donc vous faire la main sur les <a href="/random">questions ouvertes</a>.
                    </div>
                    <div v-if="!isPreparing() && isTooHard()" class="alert alert-warning">
                        Les réponses à cette question ou les catégories associées sont parfois difficiles à
                        interpréter et nécessitent d'avoir un peu d'expérience avec la plateforme.
                        Nous vous conseillons de ne venir travailler sur cette question qu'à partir d'un score
                        de {{ question.minimal_score }} annotations réalisées. Pour cela, vous pouvez vous faire
                        la main sur <a href="/random">des questions plus faciles</a>.
                    </div>
                    <action-button @clicked="loadNext"
                                   :disabled="loading" :style="'float: right;'"
                                   :btnClass="'btn-light'" :iconClass="'fa-step-forward'"
                                   :text="'Lire une autre'"></action-button>
                </div>
            </div>
        </div>
        <modal-create-tag :question="question" :can-bulb="showBulb()" :question-score="getQuestionScore()"
                          :can-create="canCreateTag()" @tagCreated="onTagCreated"></modal-create-tag>
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
                loading: false,
            }
        },
        props: {
            demo: {
                type: Boolean,
                required: true,
            },
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
        mounted() {
            let self = this;
            window.addEventListener('keyup', function (event) {
                if (event.code === 'Enter' || event.code === 'NumpadEnter') {
                    if (self.tagIds().length > 0 && !($('#modalCreate').hasClass('show'))) {
                        self.$refs.saveButton.onClick();
                    }
                }
            });
        },
        methods: {
            formattedText() {
                return this.response.value.split("\n");
            },
            canCreateTag() {
                if (this.user == null) {
                    return false;
                }
                if (this.user.role === 'admin') {
                    return true;
                }
                return this.getQuestionScore() >= 50;
            },
            score() {
                return this.user == null ? 0 : this.user.scores.total;
            },
            canTagQuestion() {
                return (this.question.status === 'open' && this.score() >= this.question.minimal_score) || (this.user !== null && this.user.role === 'admin')
            },
            isPreparing() {
                return this.question.status === 'preparing';
            },
            isTooHard() {
                return this.score() < this.question.minimal_score;
            },
            getQuestionScore() {
                if (this.user == null) {
                    return 0;
                }
                let question_scores = this.user.scores.questions;
                if (this.question.id in question_scores) {
                    return question_scores[this.question.id];
                } else {
                    return 0;
                }
            },
            showLevel() {
                return (!this.demo) && (this.user != null) && (this.user.scores.total == this.level[0]) && (this.user.scores.total > 0);
            },
            showProgress() {
                return (!this.demo) && (this.user != null) && (this.user.scores.total != this.level[0]) && (this.user.scores.total > 0) && ((this.user.scores.total % 25) == 0);
            },
            showEasyHelp() {
                return (!this.demo) && (this.user !== null) && (this.user.scores.total < 10) && (this.question.status === 'open');
            },
            showBulb() {
                return (!this.demo) && (this.user !== null) && (this.user.scores.total >= 50);
            },
            showBulbHelp() {
                return (!this.demo) && this.showBulb() && (this.user.scores.total < 60);
            },
            showWarningAccount() {
                return (!this.demo) && (this.user == null) && (this.question.status === 'open') && (this.question.minimal_score == 0);
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
            async sendSave(callback) {
                await this.send('save');
                callback();
            },
            async sendNoanswer(callback) {
                await this.send('noanswer');
                callback();
            },
            async sendLightbulb(callback) {
                await this.send('lightbulb');
                callback();
            },
            async send(message) {
                if (this.demo && this.user == null) {
                    window.location = '/register?demo=true';
                    return;
                }
                try {
                    this.loading = true;
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
                    this.user.scores = result.scores;
                    this.key = result.key;
                    this.previousResponse = result.previousResponse;
                    this.response = result.response;
                    this.level = result.level;
                    $('#myScore')[0].className = 'badge badge-pill badge-' + result.level[1];
                    $('#myScore')[0].innerHTML = '' + result.scores.total + ' - ' + result.level[2];
                    this.loading = false;
                    if (this.demo) {
                        window.location = '/questions/' + this.question.id + '/read';
                        return;
                    }
                    this.resetScreen();
                } catch (error) {
                    window.location = '/questions/' + this.question.id + '/read';
                    return;
                }
            },
            async loadNext(callback) {
                // Retrieve next response data
                try {
                    this.loading = true;
                    let result = await $.ajax({
                        url: '/api/questions/' + this.question.id + '/next',
                        type: 'GET',
                        data: {
                            key: this.key,
                        },
                    });
                    this.key = result.key;
                    this.previousResponse = result.previousResponse;
                    this.response = result.response;
                    this.loading = false;
                    callback();
                    this.resetScreen();
                } catch (error) {
                    window.location = '/questions/' + this.question.id + '/read';
                    return;
                }
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
                if (!this.demo) {
                    document.documentElement.scrollTo(0, 1);
                }
            }
        }
    }
</script>

<style>
    @keyframes example1 {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes example2 {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .quote1 {
        animation-name: example1;
        animation-duration: 1s;
    }

    .quote2 {
        animation-name: example2;
        animation-duration: 1s;
    }

    .quotation {
        margin: 5px;
    }

    .create-btn {
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>