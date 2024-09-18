import './bootstrap'
import { createApp } from 'vue'
// ルーティングの定義をインポートする
import router from './router'
// ルートコンポーネントをインポートする
import App from './App.vue'
import store from './store'
// 確認ダイアログ
import VuejsDialog from 'vuejs-dialog';
// css
import '../css/app.css';


//createApp.use(VuejsDialog);

createApp(App).use(store).use(router).mount('#app')