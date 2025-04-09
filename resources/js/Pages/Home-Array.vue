// Home.vue
<template>
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100 py-12 px-6">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-extrabold text-center text-indigo-700 mb-10 animate-fade-in-up">🧠 Laravel Quiz Challenge</h1>

            <!-- Difficulty Selector -->
            <div class="flex justify-center mb-10">
                <button
                    v-for="level in ['easy', 'medium', 'hard']"
                    :key="level"
                    @click="selectDifficulty(level)"
                    class="px-5 py-2 rounded-full text-white font-semibold capitalize shadow-md transition hover:scale-105"
                    :class="{
                        'bg-green-500 hover:bg-green-600': level === 'easy',
                        'bg-yellow-500 hover:bg-yellow-600': level === 'medium',
                        'bg-red-500 hover:bg-red-600': level === 'hard'
                    }"
                >
                    {{ level }}
                </button>
            </div>

            <form @submit.prevent="submitQuiz" class="space-y-8">
                <div
                    v-for="(question, i) in questions"
                    :key="i"
                    class="bg-white rounded-3xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300"
                >
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ question.question }}</h2>
                    <div class="space-y-3">
                        <label
                            v-for="(option,j) in question.options"
                            :key="j"
                            class="flex items-center gap-3 p-2 rounded-lg cursor-pointer hover:bg-indigo-50 transition"
                        >
                            <input
                                type="radio"
                                :name="'q_' + i"
                                :value="option"
                                v-model="answers[i]"
                                class="h-5 w-5 text-indigo-600 focus:ring-indigo-500"
                            />
                            <span class="text-gray-700">{{ option }}</span>
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
        <button
            v-if="showInstallButton"
            @click="promptInstall"
            class="fixed bottom-4 right-4 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg transition"
        >
            Install Quiz App
        </button>
    </div>
</template>

<script>
import { router } from '@inertiajs/vue3';
export default {
    props: ['questions'],
    data() {
        return {
            answers: {},
            showInstallButton: false,
            deferredPrompt: null
        };
    },
    mounted() {
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            this.deferredPrompt = e;
            this.showInstallButton = true;
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('✅ SW registered:', reg))
                    .catch(err => console.error('❌ SW failed:', err));
            });
        }
    },
    methods: {
        submitQuiz() {
            let score = 0;
            this.questions.forEach((q, i) => {
                if (this.answers[i] === q.answer) {
                    score++;
                }
            });
            console.log(score);
            this.$inertia.get('/result', {
                score: score,
            });
        },
        promptInstall() {
            if (this.deferredPrompt) {
                this.deferredPrompt.prompt();
                this.deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('✅ User accepted PWA install');
                    } else {
                        console.log('❌ User dismissed PWA install');
                    }
                    this.showInstallButton = false;
                    this.deferredPrompt = null;
                });
            }
        },
        selectDifficulty(level) {
            this.$inertia.get('/', { type: level });
        },
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
