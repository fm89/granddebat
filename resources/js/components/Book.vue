<template>
    <div style="font-size: 1rem;">
        <div class="row mb-3">
            <div class="col-md-3 limit-header mb-3">
                <span @click="onHeaderClicked(1)" :style="selected === 1 ? 'font-weight: bold' : ''">Démocratie et citoyenneté</span>
            </div>
            <div class="col-md-3 limit-header mb-3">
                <span @click="onHeaderClicked(2)" :style="selected === 2 ? 'font-weight: bold' : ''">Transition écologique</span>
            </div>
            <div class="col-md-3 limit-header mb-3">
                <span @click="onHeaderClicked(3)" :style="selected === 3 ? 'font-weight: bold' : ''">Fiscalité et dépense publique</span>
            </div>
            <div class="col-md-3 limit-header mb-3">
                <span @click="onHeaderClicked(4)" :style="selected === 4? 'font-weight: bold' : ''">Organisation de l'&Eacute;tat et des services publics</span>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <b>{{ question.text }}</b>
                <br>
                <blockquote class="quote1">
                    <p class="quotation">
                        <span v-for="line in formattedText()">{{ line }}<br/></span>
                    </p>
                    <footer>
                        <a target="_blank" :href="'/proposals/' + response.proposal_id">
                            &ndash; {{ response.city + ', le ' + response.published_at }}
                        </a>
                    </footer>
                </blockquote>
                <br>
                <action-button @clicked="swapOpen" :disabled="!canSeeTags() || loading"
                               btnClass="btn-soft" :iconClass="'fa-pen'"
                               text="Annoter cette réponse"></action-button>
                <action-button @clicked="loadNextResponse" :disabled="loading"
                               btnClass="btn-soft" :iconClass="'fa-step-forward'"
                               text="Lire une autre réponse"></action-button>
                <action-button @clicked="loadNextQuestion" :disabled="loading"
                               btnClass="btn-soft" :iconClass="'fa-question'"
                               text="Changer de question"></action-button>
                <div v-if="canSeeTags() && isOpen">
                    <hr>
                    <b>Selon vous, quelles idées clefs résument le mieux ce qu'a voulu dire le répondant ?</b>
                    <br><br>
                    <div>
                        <toggle-button v-for="(tag, index) in tags" :tag="tag" :key="index"
                                       @tagToggled="onTagToggled(tag.id)"></toggle-button>
                        <button class="btn btn-light create-btn" disabled>
                            <i class="fa fa-plus"></i>
                            <span>Créer</span>
                        </button>
                        <br/><br/>
                        <action-button @clicked="gotoRegister()" :disabled="false"
                                       :btnClass="'btn-primary'" :iconClass="'fa-check'" :text="'Valider'"></action-button>
                        <action-button @clicked="gotoRegister()" :disabled="false"
                                       :btnClass="'btn-secondary'" :iconClass="'fa-times-circle'"
                                       :text="'Sans réponse'"></action-button>
                    </div>
                </div>
                <div v-if="!canSeeTags()">
                    <br>
                    <i>
                        Vous ne pouvez pas voir les catégories pour cette question sans être connecté à votre compte.
                        Continuez à lire, <a href="/register">inscrivez-vous</a> ou <a href="/login">connectez-vous</a>.
                    </i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selected: 1,
                question_rank: 0,
                questions: this.initialQuestions,
                question: this.initialQuestions[0],
                tags: this.initialTags,
                response: this.initialResponse,
                isOpen: false,
                loading: false,
            }
        },
        props: {
            initialQuestions: {
                type: Array,
                required: true,
            },
            initialResponse: {
                type: Object,
                required: true,
            },
            initialTags: {
                type: Array,
                required: true,
            }
        },
        methods: {
            formattedText() {
                return this.response.value.split("\n");
            },
            swapOpen(callback) {
                this.isOpen = !this.isOpen;
                callback();
            },
            async onHeaderClicked(id) {
                try {
                    this.loading = true;
                    let resultQuestions = await $.ajax({
                        url: '/api/debates/' + id,
                        type: 'GET',
                        data: {
                        },
                    });
                    resultQuestions = resultQuestions.questions;
                    let resultResponse = await $.ajax({
                        url: '/api/responses/random',
                        type: 'GET',
                        data: {
                            question_id: resultQuestions[0].id,
                        },
                    });
                    let resultTags = await $.ajax({
                        url: '/api/questions/' + resultQuestions[0].id + '/tags',
                        type: 'GET',
                        data: {
                        },
                    });
                    this.selected = id;
                    this.question_rank = 0;
                    this.questions = resultQuestions;
                    this.question = this.questions[0];
                    this.tags = resultTags;
                    this.response = resultResponse;
                    this.resetScreen();
                } catch (error) {
                    // Do nothing
                }
            },
            onTagToggled(tagId) {
                $.each(this.tags, function (index, tag) {
                    if (tag.id === tagId) {
                        tag.checked = !tag.checked;
                    }
                });
            },
            canSeeTags() {
                return (this.question.status === 'open') && (this.question.minimal_score === 0);
            },
            gotoRegister() {
                window.location = '/register?demo=true';
            },
            async loadNextQuestion(callback) {
                let nextRank = this.question_rank + 1;
                if (nextRank >= this.questions.length) {
                    nextRank = 0;
                }
                try {
                    this.loading = true;
                    let resultResponse = await $.ajax({
                        url: '/api/responses/random',
                        type: 'GET',
                        data: {
                            question_id: this.questions[nextRank].id,
                        },
                    });
                    let resultTags = await $.ajax({
                        url: '/api/questions/' + this.questions[nextRank].id + '/tags',
                        type: 'GET',
                        data: {
                        },
                    });
                    this.question_rank = nextRank;
                    this.question = this.questions[nextRank];
                    this.tags = resultTags;
                    this.response = resultResponse;
                    this.resetScreen();
                } catch (error) {
                    // Do nothing
                }
                callback();
            },
            async loadNextResponse(callback) {
                try {
                    this.loading = true;
                    let result = await $.ajax({
                        url: '/api/responses/random',
                        type: 'GET',
                        data: {
                            question_id: this.question.id,
                        },
                    });
                    this.response = result;
                    this.resetScreen();
                } catch (error) {
                    // Do nothing
                }
                callback();
            },
            resetScreen() {
                // Trick to replay the CSS animation
                $('blockquote').toggleClass('quote1');
                $('blockquote').toggleClass('quote2');
                // Uncheck all tags
                this.tags.forEach(function (tag) {
                    tag.checked = false;
                });
                this.isOpen = false;
                this.loading = false;
            }
        }
    }
</script>

<style>
    .limit-header {
        text-align: center;
    }

    .limit-header span {
        background-image: linear-gradient(to right, transparent 50%, #BDDCFD 50%);
        background-size: 200% 10%;
        background-repeat: repeat-x;
        background-position: -100% 100%;
    }

    .limit-header span:hover {
        cursor: pointer;
    }

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
