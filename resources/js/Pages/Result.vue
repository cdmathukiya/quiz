<template>
     <div class="bg-gradient-to-br from-indigo-200 via-purple-100 to-pink-100">
        <div class="min-h-screen flex items-center justify-center  px-4 relative overflow-hidden mb-5">
             <canvas ref="confettiCanvas" class="absolute inset-0 z-0 pointer-events-none"></canvas>
             <div class="bg-white rounded-3xl p-10 max-w-md w-full text-center animate-fade-in-up z-10">
                 <h1 class="text-4xl font-bold text-indigo-700 mb-4">🎉 Your Quiz Result</h1>
                 <p class="text-xl text-gray-700 mb-2">You scored</p>
                 <div class="text-7xl font-extrabold text-purple-600 mb-4 fireworks">{{ score }}/5</div>
                 <p class="text-lg text-gray-600 mb-6">
                     {{ feedback }}
                 </p>
                 <Link
                     :href="route('quiz.home')"
                     class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-full text-lg font-semibold transition duration-300 transform hover:scale-105"
                 >
                     Try Again
                 </Link>
                 <p class="text-sm text-gray-500 my-5">
                     Redirecting to quiz page in <span class="font-semibold text-indigo-600">{{ countdown }}</span> seconds...
                 </p>
                 <!-- Animated Answer Button -->
                 <button @click="scrollToAnswers" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-2xl shadow-md hover:bg-blue-700 transition-transform transform hover:scale-105 animate-bounce">
                     See Answers
                 </button>
             </div>
         </div>

        <div ref="answerSection" class="flex items-center w-full max-w-4xl mx-auto justify-center space-y-6 ">
            <div class="bg-white rounded-3xl shadow-md p-6 overflow-hidden mb-5">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Quiz Review</h2>
                <p class="text-gray-600 mb-6">Here are the correct answers for your reference</p>

                <div class="space-y-6">
                    <div
                        v-for="(question, index) in questions"
                        :key="question.id"
                        class="border-l-4 border-indigo-300 pl-5 py-2 hover:border-indigo-500 transition-colors duration-200"
                    >
                        <div class="flex items-start">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-800 font-bold mr-4 mt-1 flex-shrink-0">
                                {{ index + 1 }}
                            </span>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ question.question }}</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-700 mb-1">
                                        <span class="font-bold text-indigo-600">Answer:</span> {{ question.answer }}
                                    </p>
                                    <p class="text-gray-700">
                                        <span class="font-bold text-indigo-600">Reference:</span> {{ question.reference }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
export default {
    components: {
        Link
    },
    props: ['questions', 'score'],
    data() {
        return {
            countdown: 120,
            allowNavigation: false
        };
    },
    computed: {
        feedback() {
            if (this.score === 5) return 'Excllent score! 🚀';
            if (this.score >= 4) return 'Great job! Almost there! 💪';
            if (this.score >= 3) return 'Nice try! Keep practicing. 🙌';
            return 'Don’t worry, try again and learn more! 📚';
        }
    },
    mounted() {
        window.addEventListener('beforeunload', this.handleBeforeUnload);
        
        const interval = setInterval(() => {
            if (this.countdown > 1) {
                this.countdown--;
            } else {
                clearInterval(interval);
                this.route('quiz.home')
            }
        }, 4000);

        if (this.score >= 2) {
            this.launchConfetti();
        }
        this.answerSection = this.$refs.answerSection;
    },
    beforeUnmount() {
        window.removeEventListener('beforeunload', this.handleBeforeUnload);
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
        launchConfetti() {
            const canvas = this.$refs.confettiCanvas;
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            const pieces = [];
            for (let i = 0; i < 150; i++) {
                pieces.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height - canvas.height,
                    radius: Math.random() * 6 + 4,
                    color: `hsl(${Math.random() * 360}, 100%, 70%)`,
                    speedY: Math.random() * 3 + 2,
                    tilt: Math.random() * 10 - 5
                });
            }

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (let p of pieces) {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                    ctx.fillStyle = p.color;
                    ctx.fill();
                }
            }

            function update() {
                for (let p of pieces) {
                    p.y += p.speedY;
                    p.x += Math.sin(p.y * 0.05);
                }
            }

            function animate() {
                draw();
                update();
                requestAnimationFrame(animate);
            }

            animate();
        },
        scrollToAnswers() {
            this.answerSection.scrollIntoView({ behavior: 'smooth' });
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

@keyframes fireworks {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.3); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out;
}

.fireworks {
    animation: fireworks 0.8s ease-in-out infinite;
}
</style>
