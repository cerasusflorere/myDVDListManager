<template>
  <div class="detail-area">
    <!--- 閲覧/編集 -->
    <div class="detail-show-button-area">
      <button type="button" v-show="tab === 1" class="detail-show-button" @click="alterTab"><i class="fas fa-edit fa-fw"></i>編集</button>
      <button type="button" v-show="tab === 2" class="detail-show-button" @click="alterTab"><i class="fas fa-eye fa-fw"></i>閲覧</button>
    </div>

    <div v-show="tab === 1" class="detail-show-area">
      <div v-if="showDVDs.length" class="list-list-table-box">
        <div class="list-list-table-headerline">
          <div class="list-list-table-cell list-list-table-headercell list-list-table-number-cell list-list-table-non"></div>
          <div class="list-list-table-cell list-list-table-headercell list-list-table-title-cell">タイトル</div>
          <div class="list-list-table-cell list-list-table-headercell list-list-table-name-cell">貸している人</div>
          <div class="list-list-table-cell list-list-table-headercell list-list-table-startdate-cell">いつから</div>
        </div>
        <div class="list-list-table-bodyblock">
          <div v-for="(DVD, index) in showDVDs" class="list-list-table-bodyline">
            <div class="list-list-table-cell list-list-table-bodycell list-list-table-number-cell">{{ index + 1 }}</div>
            <!-- タイトル -->
            <RouterLink v-bind:to="{ name: 'detail', params: { propDVD: DVD.id} }" class="list-list-table-cell list-list-table-bodycell  list-list-table-title-cell list-list-table-button" target="_blank" rel="noopener noreferrer">
              {{ DVD.title }}
            </RouterLink>
            <!-- 貸している人 -->
            <div v-if="DVD.rents.length" class="list-list-table-cell list-list-table-bodycell list-list-table-name-cell">{{ DVD.rents[0].name }}</div>
            <div v-else class="list-list-table-cell list-list-table-bodycell list-list-table-name-cell green"><i class="far fa-circle"></i></div>
            <!-- いつから -->
            <div v-if="DVD.rents.length" class="list-list-table-cell list-list-table-bodycell list-list-table-startdate-cell">{{ DVD.rents[0].start_date }}</div>
            <div v-else class="list-list-table-cell list-list-table-bodycell list-list-table-startdate-cell"></div>
          </div> 
        </div>
      </div>

      <div v-else class="list-non-area">
        DVDは登録されていません。
      </div>
    </div>

    <!-- 編集 -->
    <div v-show="tab === 2" class="rent-edit-area">
      <div v-if="showDVDs.length" class="rent-edit-area">
        <div class="rent-edit-input-area">
          <div class="rent-edit-name-area">
            <label class="detail-edit-header">名前:</label>
            <input type="text" v-model="rentData.name" class="detail-edit-name">
          </div>
          
          <input type="date" v-model="rentData.startdate" class="detail-edit-date">
        </div>
        <div class="list-list-table-box">
          <div class="list-list-table-headerline">
            <div class="list-list-table-cell list-list-table-headercell list-list-table-number-cell list-list-table-non"></div>
            <div class="list-list-table-cell list-list-table-headercell list-list-table-title-cell">タイトル</div>
            <div class="list-list-table-cell list-list-table-headercell list-list-table-name-cell">貸している人</div>
            <div class="list-list-table-cell list-list-table-headercell list-list-table-startdate-cell">いつから</div>
          </div>
          <div class="list-list-table-bodyblock">
            <div v-for="(DVD, index) in showDVDs" class="list-list-table-bodyline">
              <div class="list-list-table-cell list-list-table-bodycell list-list-table-number-cell">
                <input type="checkbox" v-model="rentData.check[index]">
              </div>              
              <!-- タイトル -->
              <RouterLink v-bind:to="{ name: 'detail', params: { propDVD: DVD.id} }" class="list-list-table-cell list-list-table-bodycell  list-list-table-title-cell list-list-table-button" target="_blank" rel="noopener noreferrer">
                {{ DVD.title }}
              </RouterLink>
              <!-- 貸している人 -->
              <div v-if="DVD.rents.length" class="list-list-table-cell list-list-table-bodycell list-list-table-name-cell">{{ DVD.rents[0].name }}</div>
              <div v-else class="list-list-table-cell list-list-table-bodycell list-list-table-name-cell green"><i class="far fa-circle"></i></div>
              <!-- いつから -->
              <div v-if="DVD.rents.length" class="list-list-table-cell list-list-table-bodycell list-list-table-startdate-cell">{{ DVD.rents[0].start_date }}</div>
              <div v-else class="list-list-table-cell list-list-table-bodycell list-list-table-startdate-cell"></div>
            </div> 
          </div>
        </div>
        <div class="rent-edit-button-area">
          <button type="button" class="rent-edit-button" @click="rentDVD">貸出</button>
          <button type="button" class="rent-edit-button" @click="returnDVD">返却</button>
        </div>
      </div>      

      <div v-else class="list-non-area">
        DVDは登録されていません。
      </div>
    </div>    
  </div>
</template>

<script>
import { OK, UNPROCESSABLE_ENTITY } from '../util'
import messageDialog from '../components/Message_Dialog.vue'
import confirmDialog from '../components/Confirm_Dialog.vue'

export default {
  
  // このページの上で表示するコンポーネント
  components: {
    messageDialog,
    confirmDialog
  },
  // データ
  data() {
    return {
      //　オリジナルデータ
      DVDs: [],
      // 見せる
      showDVDs: [],
      // 編集
      rentData: {
        name:'',
        startdate:'',
        check:[]
      },

      // タブ
      tab: 1
    }
  },
  watch: {
    $route: {
      async handler () {
          await this.fetchDVDs();
        },
        immediate: true
    }
  },
  methods: {
    // DVD取得
    async fetchDVDs () {
      const response = await axios.get('/api/DVDs_rent');

      if (response.status !== 200) {
        this.$store.commit('error/setCode', response.status);
        return false;
      }

      this.DVDs = response.data; // オリジナルデータ
      [...Array(this.DVDs.length)].map(() => this.rentData.check.push(false));
      this.showDVDs = JSON.parse(JSON.stringify(this.DVDs));
    },

    // 貸出
    async rentDVD() {
      if(this.rentData.name && this.rentData.startdate && this.rentData.check.find(value => value == true)) {
        let rentDVDs = [];
        this.rentData.check.forEach((value, index) => {
          if(value) {
            rentDVDs.push(this.showDVDs[index].id);
          }
        });

        const formData = new FormData();
        formData.append('name', this.rentData.name);
        formData.append('startdate', this.rentData.startdate);
        formData.append('rents', JSON.stringify(rentDVDs));

        const response = await axios.post('/api/rent', formData);
        await this.fetchDVDs();

        this.rentData.name = '';
        this.rentData.startdate = '';
        this.rentData.check = [];
        [...Array(this.DVDs.length)].map(() => this.rentData.check.push(false));
      }
    },

    // 返却
    async returnDVD() {
      if(this.rentData.check.find(value => value == true)) {
        let returnDVDs = [];
        this.rentData.check.forEach((value, index) => {
          if(value) {
            returnDVDs.push(this.showDVDs[index].id);
          }
        });

        const formData = new FormData();
        formData.append('returns', JSON.stringify(returnDVDs));

        const response = await axios.post('/api/return', formData);
        await this.fetchDVDs();

        this.rentData.name = '';
        this.rentData.startdate = '';
        this.rentData.check = [];
        [...Array(this.DVDs.length)].map(() => this.rentData.check.push(false));
      }
    },

    // タブ切り替え
    alterTab() {
      if(this.tab === 1){
        this.tab = 2;
      }else{
        this.tab = 1;
      }
    }
  }
}
</script>