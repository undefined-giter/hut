<template>
    <div class="mt-4 mb-8">
        <div class="flex">
            <h3 class="text-orange-700 dark:text-orangeTheme shadow-md p-2 inline-block">Commentaire{{ admin_comments.length > 1 ? 's' : ''}} d'admin</h3>
            <button @click="toggleComments" class="ml-2 p-2 bg-gray-300 dark:bg-gray-800 rounded">
                {{ showComments ? '🔼' : '🔽' }}
            </button>
        </div>
        <span class="text-gray-800 dark:text-gray-500" v-if="showComments">
            {{ admin_comments.length > 1 ? 'Commentaires visibles' : 'Commentaire visible' }} seulement par vous, admin.
        </span>

        <ul v-if="showComments && admin_comments.length > 0">
            <li v-for="comment in admin_comments" :key="comment.id">
                <p class="inline whitespace-pre-wrap break-words">{{ comment.content }}</p>
                <button @click="startEditing(comment)" class="ml-2 hover:text-blue-600 text-blue-700">Modifier</button>
                <button @click="deleteComment(comment.id)" class="ml-2 text-red-700 hover:text-red-600">Supprimer</button>
            </li>
        </ul>

        <div v-if="showComments">
            <div class="flex justify-end">
                <p v-if="newCommentLength != 0" :class="newCommentLength >= 1000 ? '!text-orange-600' : ''" class="-mb-5">
                    {{ newCommentLength }}/1000 caractères
                </p>
                <p v-else class="-mb-5"> </p>
            </div>
            <textarea 
                v-model="newComment" 
                placeholder="Décrivez l'expérience avec cet/ces utilisateurs comme mémo" 
                class="border rounded w-full mt-4"
                maxlength="1000"
                @input="updateCharacterCount"
            ></textarea>
            <p v-if="error" class="!text-red-600">{{ error }}</p>
            <div class="flex justify-end mr-4">
                <button 
                    @click="saveComment" 
                    class="btn" 
                    :class="{
                        'btn-disabled': error != '' || newComment.trim() === ''
                    }" 
                    :disabled="newCommentLength > 1000 || newComment.trim() === ''"
                >
                    {{ isEditing ? 'Modifier' : 'Ajouter' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { checkCharacterCount } from './../../../js/shared/utils';

const props = defineProps({
    user_id: Number,
    admin_comments: {
        type: Array,
        default: () => []
    },
});

const showComments = ref(false);
const newComment = ref('');
const isEditing = ref(false);
let editingCommentId = ref(null);
const error = ref('');
const newCommentLength = ref(0);

const toggleComments = () => {
    showComments.value = !showComments.value;
};

const saveComment = () => {
    const { valid, message } = checkCharacterCount(newComment.value, 1000);

    if (!valid) {
        error.value = message;
        return;
    }

    if (newComment.value.trim() === '') {
        error.value = 'Le commentaire ne peut pas être vide.';
        return;
    }

    const action = isEditing.value
        ? Inertia.put(route('admin.comment.update', editingCommentId.value), {
            content: newComment.value,
        })
        : Inertia.post(route('admin.comment.store'), {
            user_id: props.user_id,
            content: newComment.value,
        });

    action.then(() => {
        newComment.value = '';
        isEditing.value = false;
        editingCommentId.value = null;
        error.value = '';
        newCommentLength.value = 0;
    }).catch(err => {
        error.value = isEditing.value 
            ? 'Une erreur est survenue lors de la mise à jour du commentaire.' 
            : 'Une erreur est survenue lors de l\'ajout du commentaire.';
    });
};

const startEditing = (comment) => {
    newComment.value = comment.content;
    isEditing.value = true;
    editingCommentId.value = comment.id;
    newCommentLength.value = checkCharacterCount(comment.content, 1000).valid 
        ? comment.content.replace(/\r?\n/g, '  ').length 
        : 1000;
};

const deleteComment = (commentId) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) {
        Inertia.delete(route('admin.comment.delete', commentId));
    }
};

const updateCharacterCount = () => {
    const { valid, message, remaining } = checkCharacterCount(newComment.value, 1000);
    newCommentLength.value = valid ? message.split('/')[0].trim() : 1000;
    error.value = !valid ? message : '';
};
</script>
