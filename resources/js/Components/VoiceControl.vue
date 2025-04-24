<template>
  <div class="voice-control">
    <button
      @click="toggleListening"
      :class="[
        'voice-btn',
        isListening ? 'bg-red-500' : 'bg-blue-500',
        'text-white font-bold py-2 px-4 rounded-full flex items-center space-x-2'
      ]"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z"
          clip-rule="evenodd"
        />
      </svg>
      <span>{{ isListening ? 'Listening...' : 'Start Voice Command' }}</span>
    </button>

    <div v-if="transcript" class="mt-4 p-4 bg-gray-100 rounded-lg">
      <p class="font-medium">Recognized Text:</p>
      <p class="text-gray-700">{{ transcript }}</p>
    </div>

    <div v-if="lastCommand" class="mt-4 p-4 bg-blue-100 rounded-lg">
      <p class="font-medium">Last Command:</p>
      <p class="text-gray-700">{{ lastCommand }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'

const isListening = ref(false)
const transcript = ref('')
const lastCommand = ref('')
let recognition = null

const commands = {
  'add product': () => router.visit(route('products.create')),
  'list products': () => router.visit(route('products.index')),
  'add stock': () => router.visit(route('stock-movements.create')),
  'view stock': () => router.visit(route('stock-movements.index')),
  'search for': (query) => {
    router.visit(route('products.index', { search: query }))
  }
}

const speak = (text) => {
  const speech = new SpeechSynthesisUtterance(text)
  speech.lang = 'en-US'
  window.speechSynthesis.speak(speech)
}

const processCommand = (text) => {
  const lowerText = text.toLowerCase()
  lastCommand.value = text

  // Handle search commands
  if (lowerText.startsWith('search for')) {
    const query = text.substring(10).trim()
    commands['search for'](query)
    speak(`Searching for ${query}`)
    return
  }

  // Handle direct commands
  for (const [command, action] of Object.entries(commands)) {
    if (lowerText.includes(command)) {
      action()
      speak(`Executing command: ${command}`)
      return
    }
  }

  speak("Sorry, I didn't understand that command")
}

const setupSpeechRecognition = () => {
  if (!('webkitSpeechRecognition' in window)) {
    alert('Speech recognition is not supported in this browser')
    return
  }

  recognition = new webkitSpeechRecognition()
  recognition.continuous = false
  recognition.interimResults = true
  recognition.lang = 'en-US'

  recognition.onstart = () => {
    isListening.value = true
    speak('Listening for command')
  }

  recognition.onend = () => {
    isListening.value = false
  }

  recognition.onresult = (event) => {
    const current = event.resultIndex
    transcript.value = event.results[current][0].transcript

    if (event.results[current].isFinal) {
      processCommand(transcript.value)
    }
  }

  recognition.onerror = (event) => {
    console.error('Speech recognition error:', event.error)
    isListening.value = false
  }
}

const toggleListening = () => {
  if (!recognition) {
    setupSpeechRecognition()
  }

  if (isListening.value) {
    recognition.stop()
  } else {
    recognition.start()
  }
}

onMounted(() => {
  setupSpeechRecognition()
})

onUnmounted(() => {
  if (recognition) {
    recognition.stop()
  }
})
</script>

<style scoped>
.voice-btn {
  transition: all 0.3s ease;
}

.voice-btn:hover {
  transform: scale(1.05);
}

.voice-btn:active {
  transform: scale(0.95);
}
</style>
