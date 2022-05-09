import { createApp } from 'vue';

import App from './App.vue';
import router from './router';
import Default from './layouts/default.vue';
import Auth from './layouts/auth.vue';
import Blank from './layouts/blank.vue';
import FDefault from './layouts/Frontend/default.vue';


import common from './common';

// createApp(App).mount('#app')
const app = createApp(App)

app.mixin(common)
    .component('default-layout', Default)
    .component('auth-layout', Auth)
    .component('blank-layout', Blank)
    .component('fdefault-layout', FDefault);


app.use(router);
app.mount('#app');