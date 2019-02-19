<template>
    <div class="modal" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Créer une nouvelle catégorie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="canCreate">
                        <div class="alert alert-warning">
                            Vous allez créer une nouvelle catégorie. Pour l'efficacité du travail collectif et la qualité
                            des analyses à venir, ces catégories doivent :
                            <ul>
                                <li>être <b>fréquentes</b> (n'en créez pas avant d'avoir vu plusieurs fois une même idée,
                                    quitte à passer les premières fois que vous la voyez ou utiliser la catégorie "Autres"),</li>
                                <li>constituer <b>une réponse à la question posée</b> et pas à une autre question
                                    (dans ce cas, utilisez le bouton "Sans réponse"<span v-if="canBulb">, ou "Marquer l'idée"</span>),</li>
                                <li>ne <b>pas être trop proches</b> de catégories déjà existantes (le but étant de regrouper
                                    des contributions mentionnant des idées analogues sous une même catégorie),</li>
                                <li>être désignées par des <b>libellés synthétiques</b> (pour la lisibilité de l'interface et ne pas vous noyer).</li>
                            </ul>
                        </div>
                        <b>{{ question.text }}</b>
                        <br/><br/>
                        <div class="form-group">
                            <label for="name" class="control-label">Nom de la catégorie</label>
                            <input type="text" name="name" id="name" v-model="name" :class="'form-control' + (error ? ' is-invalid' : '')"/>
                            <span class="invalid-feedback" role="alert" v-if="error">
                            <strong>Ce nom de catégorie existe déjà. Vous pouvez donc déjà le cocher pour l'utiliser.</strong>
                        </span>
                        </div>
                        <button @click="createTag()" class="btn btn-primary" :disabled="name.length < 2">
                            <i class="fa fa-btn fa-plus"></i> Créer la catégorie
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Annuler
                        </button>
                    </div>
                    <div v-else>
                        <div class="alert alert-info">
                            <p>
                                Pour le moment, vous avez annoté {{ questionScore }}
                                {{ questionScore > 1 ? 'réponses' : 'réponse' }} à cette question.
                                La création de nouvelles catégories est une fonctionnalité
                                disponible à partir de 50 annotations réalisées sur une même question.
                                En effet, il est nécessaire de lire suffisamment avant de pouvoir créer des catégories
                                pertinentes et assez fréquentes.
                            </p>
                            En attendant de pouvoir créer vos propres catégories, vous pouvez
                            <ul>
                                <li>cocher la catégorie qui s'en rapproche le plus,</li>
                                <li>cocher une catégorie neutre telle que "Autres",</li>
                                <li>utiliser le bouton gris "Sans réponse" pour les idées hors sujet ou ne répondant pas directement à la question,</li>
                                <li v-if="canBulb">utiliser le bouton jaune "Marquer l'idée" pour les textes particulièrement argumentés et construits,</li>
                                <li>passer la réponse sans l'annoter.</li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Retour
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                error: false,
            }
        },
        props: {
            question: {
                type: Object,
                required: true,
            },
            canBulb: {
                type: Boolean,
                required: true,
            },
            canCreate: {
                type: Boolean,
                required: true,
            },
            questionScore: {
                type: Number,
                required: true,
            }
        },
        methods: {
            async createTag() {
                let tag = await $.ajax({
                    url: '/api/tags',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        question_id: this.question.id,
                        name: this.name,
                    }
                });
                if (tag.id == null) {
                    this.error = true;
                } else {
                    this.error = false;
                    this.name = '';
                    this.$emit('tagCreated', tag);
                }
            },
        }
    }
</script>