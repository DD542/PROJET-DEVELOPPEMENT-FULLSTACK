<template>
  <div class="flex h-screen bg-slate-50 font-sans text-slate-900">
    
    <aside class="w-72 bg-indigo-950 text-white flex flex-col shadow-xl">
      <div class="p-8 flex items-center space-x-3 border-b border-indigo-900">
        <div class="bg-indigo-500 p-2 rounded-lg"><BrainCircuit class="w-6 h-6"/></div>
        <span class="text-2xl font-black tracking-tighter">ReviewAI</span>
      </div>
      
      <nav class="flex-1 p-6 space-y-4">
        <div class="text-xs font-semibold text-indigo-300 uppercase tracking-widest">Menu Principal</div>
        <a href="#" class="flex items-center p-3 bg-indigo-800 rounded-xl transition-all shadow-lg group">
          <LayoutDashboard class="mr-3 w-5 h-5 text-indigo-300 group-hover:scale-110 transition" /> 
          <span class="font-medium">Dashboard</span>
        </a>
        <a href="#" class="flex items-center p-3 text-indigo-200 hover:bg-indigo-900 rounded-xl transition group">
          <MessageSquare class="mr-3 w-5 h-5 group-hover:rotate-12 transition" /> 
          <span>Liste des avis</span>
        </a>
      </nav>

      <div class="p-6 bg-indigo-900/50 m-4 rounded-2xl border border-indigo-800">
        <p class="text-xs text-indigo-300">Statut de l'IA</p>
        <div class="flex items-center mt-1 text-green-400 text-sm font-bold">
          <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse mr-2"></div> Connecté
        </div>
      </div>
    </aside>

    <main class="flex-1 overflow-y-auto">
      <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-10 sticky top-0 z-10">
        <h2 class="text-xl font-bold flex items-center italic text-slate-700">
          Bonjour, Kevin <span class="ml-2 text-2xl font-normal">👋</span>
        </h2>
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-full font-bold shadow-lg shadow-indigo-200 transition-all flex items-center transform hover:-translate-y-0.5">
          <PlusCircle class="mr-2 w-5 h-5" /> Analyser un avis
        </button>
      </header>

      <div class="p-10 space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition">
            <span class="text-slate-400 font-bold text-xs uppercase">Note Moyenne</span>
            <div class="text-4xl font-black mt-2 text-slate-800">4.2<span class="text-lg text-slate-300 ml-1">/ 5</span></div>
          </div>
          
          <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex justify-between items-center group">
            <div>
              <span class="text-slate-400 font-bold text-xs uppercase">Satisfaction</span>
              <div class="text-4xl font-black mt-2 text-emerald-500">85%</div>
            </div>
            <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center">
              <TrendingUp class="w-8 h-8 text-emerald-500" />
            </div>
          </div>

          <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <span class="text-slate-400 font-bold text-xs uppercase">Total Avis</span>
            <div class="text-4xl font-black mt-2 text-indigo-600">1,250</div>
          </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100">
          <div class="p-6 border-b border-slate-50 flex items-center justify-between">
            <h3 class="font-bold text-lg">Analyses récentes</h3>
            <span class="text-indigo-600 text-sm font-bold cursor-pointer hover:underline">Voir tout</span>
          </div>

          <div class="divide-y divide-slate-50">
            <div v-for="review in reviews" :key="review.id" class="p-8 hover:bg-slate-50/50 transition flex items-center gap-6">
              <div :class="sentimentIconBg(review.sentiment)" class="p-4 rounded-2xl">
                <Smile v-if="review.sentiment === 'positif'" class="w-6 h-6 text-emerald-600" />
                <Frown v-else class="w-6 h-6 text-rose-600" />
              </div>
              
              <div class="flex-1">
                <p class="text-slate-700 font-medium text-lg mb-2">"{{ review.content }}"</p>
                <div class="flex flex-wrap gap-2">
                  <span v-for="topic in review.topics" :key="topic" class="bg-slate-100 text-slate-500 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider border border-slate-200">
                    # {{ topic }}
                  </span>
                </div>
              </div>

              <div class="text-right">
                <div class="font-black text-xl" :class="sentimentText(review.sentiment)">
                  {{ review.score }}<span class="text-xs font-normal">/100</span>
                </div>
                <div class="text-xs text-slate-400 font-medium">Analyse IA effectuée</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { 
  LayoutDashboard, MessageSquare, PlusCircle, BrainCircuit, 
  TrendingUp, Smile, Frown 
} from 'lucide-vue-next';

const reviews = ref([
  { 
    id: 1, 
    content: "Le service client est au top, mais le prix reste un peu cher pour mon budget.", 
    sentiment: "positif", 
    score: 82,
    topics: ["Service", "Prix"] 
  },
  { 
    id: 2, 
    content: "Livraison catastrophique, le colis est arrivé ouvert.", 
    sentiment: "négatif", 
    score: 12,
    topics: ["Livraison"] 
  }
]);

const sentimentIconBg = (s) => s === 'positif' ? 'bg-emerald-100' : 'bg-rose-100';
const sentimentText = (s) => s === 'positif' ? 'text-emerald-500' : 'text-rose-500';
</script>