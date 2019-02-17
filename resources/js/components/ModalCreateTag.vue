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
            canBulb : {
                type: Boolean,
                required: true,
            },
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