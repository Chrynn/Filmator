import {createApp} from 'vue/dist/vue.esm-bundler';
import Test from '../../app/components/test.vue';

document.addEventListener('VueMount', (e) => {
    const app = createApp({});

    app.component('test', Test);

    app.mount('#app');
});