<template>
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100 py-12 px-6">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-extrabold text-center text-indigo-700 mb-10 animate-fade-in-up">🧠 अवेक्षक चैलेंज
            </h1>
            <div v-if="errors.answers"
                class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                role="alert">
                <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Danger alert!</span> {{ errors.answers }}
                </div>
            </div>
            <div v-if="showmodel">
                <div class="fixed inset-0 bg-blue-50 flex items-center justify-center p-4 z-50">
                    <!-- Modal Content -->
                    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-8 animate-scale-in">
                        <h1 class="text-4xl font-extrabold text-center text-indigo-700 mb-10 animate-fade-in-up">🧠अवेक्षक चैलेंज</h1>
                        <div class="flex flex-col items-center mb-12 space-y-4">
                            <h3 class="text-lg font-medium text-gray-700 mb-2">Select Difficulty Level</h3>
                            <div class="flex flex-wrap justify-center gap-3">
                                <button
                                    v-for="level in levels"
                                    :key="level.value"
                                    @click="selectDifficulty(level.value)"
                                    @mouseover="hoveredLevel = level.value"
                                    @mouseleave="hoveredLevel = null"
                                    class="relative px-6 py-3 rounded-xl font-medium capitalize transition-all duration-300 transform overflow-hidden"
                                    :class="{
                                    'bg-emerald-100 text-emerald-800 border-2 border-emerald-300 hover:border-emerald-500': level.value === 'easy',
                                    'bg-amber-100 text-amber-800 border-2 border-amber-300 hover:border-amber-500': level.value === 'medium',
                                    'bg-rose-100 text-rose-800 border-2 border-rose-300 hover:border-rose-500': level.value === 'hard',
                                    'bg-blue-100 text-blue-800 border-2 border-blue-300 hover:border-blue-500': level.value === 'riddle',
                                    'ring-2 ring-offset-2 ring-indigo-400 scale-105': selectedDifficulty?.value === level.value,
                                    'opacity-90 hover:opacity-100': selectedDifficulty?.value !== level.value
                                    }"
                                >
                                    <span class="relative z-10 flex items-center">
                                    <span class="mr-2">
                                        <span v-if="level.value === 'easy'">😊</span>
                                        <span v-if="level.value === 'medium'">🤔</span>
                                        <span v-if="level.value === 'hard'">🧠</span>
                                        <span v-if="level.value === 'riddle'">🤔</span>
                                    </span>
                                    {{ level.label }}
                                    </span>
                                    <span
                                    class="absolute inset-0 opacity-0 hover:opacity-20 transition-opacity duration-300"
                                    :class="{
                                        'bg-emerald-200': level.value === 'easy',
                                        'bg-amber-200': level.value === 'medium',
                                        'bg-rose-200': level.value === 'hard',
                                        'bg-blue-200': level.value === 'riddle'
                                    }"
                                    ></span>
                                </button>
                                <p class="text-center text-gray-700 text-base md:text-lg font-semibold leading-relaxed max-w-2xl mx-auto mb-6">
                                    Ready for a challenge? Pick your difficulty Easy, Medium, or Hard and let the quiz
                                    begin!
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-center space-x-4">
                            <button type="button" @click="startChallenge" :disabled="!selectedDifficulty"
                                class="px-6 py-2 bg-indigo-600 text-white rounded-full font-medium disabled:bg-indigo-300 disabled:cursor-not-allowed hover:bg-indigo-700 transition-colors">
                                Start Quiz
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <form @submit.prevent="submitQuiz" class="space-y-8">
                <div v-for="question in questions" :key="question.id"
                    class="bg-white rounded-3xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ question.question }}</h2>
                    <div class="space-y-3">
                        <label v-for="option in question.options" :key="option.id"
                            class="flex items-center gap-3 p-2 rounded-lg cursor-pointer hover:bg-indigo-50 transition">
                            <input type="radio" required :name="'q_' + question.id" :value="option.id"
                                v-model="answers[question.id]" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500" />
                            <span class="text-gray-700">{{ option.option }}</span>
                        </label>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-full text-lg font-semibold shadow-md transition duration-300 transform hover:scale-105">
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
    props: ['questions', 'errors'],
    data() {
        return {
            answers: {},
            hoveredLevel: null,
            selectedDifficulty: null,
            allowNavigation: false,
            showmodel: true,
            levels: [
                { value: 'easy', label: 'Easy' },
                { value: 'medium', label: 'Medium' },
                { value: 'hard', label: 'Hard' },
                { value: 'riddle', label: 'ઉખાણું' }, // Riddle in Gujarati
            ],
        };
    },
    mounted() {
        window.addEventListener('beforeunload', this.handleBeforeUnload);
        const params = new URLSearchParams(window.location.search);
        let type = params.get('type');
        const validTypes = ['easy', 'medium', 'hard'];
        if (validTypes.includes(type)) {
            this.showmodel = false
        } else {
            this.showmodel = true;
        }

        if (this.questions == null) {
            this.$inertia.visit(route('quiz.home'));
            return;
        }
    },
    methods: {
        handleBeforeUnload(event) {
            if (!this.allowNavigation) {
                event.preventDefault();
            }
        },
        tryAgain() {
            this.allowNavigation = true;
            this.$inertia.visit(route('quiz.home'));
        },
        submitQuiz() {
            this.allowNavigation = true;
            router.post('/submit', {
                answers: this.answers
            });
        },
        selectDifficulty(level) {
            this.selectedDifficulty = level;
            this.allowNavigation = true;
        },
        startChallenge() {
            this.selectDifficulty(this.selectedDifficulty);
            setTimeout(() => {
                this.$inertia.get('/', { type: this.selectedDifficulty }, {
                    preserveState: true,
                    preserveScroll: true,
                    onFinish: () => {
                        this.showmodel = false;
                        this.allowNavigation = false;
                    }
                });
            }, 100);
        },
    },
    beforeUnmount() {
        window.removeEventListener('beforeunload', this.handleBeforeUnload);
    },    
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
