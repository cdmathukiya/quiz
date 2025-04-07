// Home.vue
<template>
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100 py-12 px-6">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-extrabold text-center text-indigo-700 mb-10 animate-fade-in-up">🧠 Laravel Quiz Challenge</h1>
            <form @submit.prevent="submitQuiz" class="space-y-8">
                <div
                    v-for="question in questions"
                    :key="question.id"
                    class="bg-white rounded-3xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300"
                >
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ question.question }}</h2>
                    <div class="space-y-3">
                        <label
                            v-for="option in question.options"
                            :key="option.id"
                            class="flex items-center gap-3 p-2 rounded-lg cursor-pointer hover:bg-indigo-50 transition"
                        >
                            <input
                                type="radio"
                                :name="'q_' + question.id"
                                :value="option.id"
                                v-model="answers[question.id]"
                                class="h-5 w-5 text-indigo-600 focus:ring-indigo-500"
                            />
                            <span class="text-gray-700">{{ option.option }}</span>
                        </label>
                    </div>
                </div>
                <div class="text-center">
                    <button
                        type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-full text-lg font-semibold shadow-md transition duration-300 transform hover:scale-105"
                    >
                        Submit Answers
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { router } from '@inertiajs/vue3';

export default {
    props: ['questions'],
    data() {
        return {
            answers: {}
        };
    },
    methods: {
        submitQuiz() {
            router.post('/submit', {
                answers: this.answers
            });
        }
    }
};
</script>

<style scoped>
@keyframes fade-in-up {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out;
}
</style>
