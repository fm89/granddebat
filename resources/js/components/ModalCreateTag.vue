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
                    <b>{{ question.text }}</b>
                    <br/><br/>
                    <div class="form-group">
                        <label for="name" class="control-label">Nom de la catégorie</label>
                        <input type="text" name="name" id="name" v-model="name" :class="'form-control' + (error ? ' is-invalid' : '')"/>
                        <span class="invalid-feedback" role="alert" v-if="error">
                            <strong>Ce nom de catégorie existe déjà. Vous pouvez donc déjà le cocher pour l'utiliser.</strong>
                        </span>
                    </div>
                    <button @click="createTag" class="btn btn-primary" :disabled="name.length < 2">
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
                    location.reload();
                }
            },
        }
    }
</script>