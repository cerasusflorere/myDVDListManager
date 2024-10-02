<template>
  <div class="list">
    <!-- ボタンエリア -->
    <div class="list-button-area">
      <!--表示切替ボタン-->
      <div v-show="tabList === 1" class="list-show-button-area">
        <button type="button" @click="switchDisplay" class="list-show-button"><i class="fas fa-th fa-fw"></i>写真</button>
      </div>
      <div v-show="tabList === 2" class="list-show-button-area">
        <button type="button" @click="switchDisplay" class="list-show-button"><i class="fas fa-list-ul fa-fw"></i>リスト</button>
      </div>

      <div v-if="DVDs.length" class="list-sort-button-area">
        <!-- 検索 -->
        <div class="list-sort-search-button-area">
          <button type="button" @click="openModal_searchDVD(Math.random())" class="list-sort-search-button"><i class="fas fa-search fa-fw"></i>検索</button>
        </div>
        <searchDVD :postSearch="postSearch" v-show="showContent_search" @close="closeModal_searchDVD" />

        <!-- 並び替えリセット -->
        <div class="list-sort-reset-button-area">
          <button type="button" @click="sortStandard('reset')" class="list-sort-reset-button"><i class="fas fa-undo-alt fa-fw"></i>リセット</button>
        </div>
      </div>
    </div>

    <!-- 表示エリア -->
    <div v-show="tabList === 1" class="list-list-area">
      <div v-if="showDVDs.length" class="list-list-table-box">
        <div class="list-list-table-headerline">
          <div class="list-list-table-cell list-list-table-headercell list-list-table-number-cell list-list-table-non"></div>
          <div class="list-list-table-cell list-list-table-headercell list-list-table-title-cell">タイトル</div>
          <div class="list-list-table-cell list-list-table-headercell list-list-table-category-cell">カテゴリー</div>
          <div class="list-list-table-cell list-list-table-headercell list-list-table-duration-cell">公演期間</div>
          <div class="list-list-table-cell list-list-table-headercell list-list-table-location-cell">公演地</div>
          <div class="list-list-table-cell list-list-table-headercell list-list-table-author-cell">戯曲</div>
          <div class="list-list-table-cell list-list-table-headercell list-list-table-rent-cell">貸出</div>
        </div>
        <div class="list-list-table-bodyblock">
          <div v-for="(DVD, index) in showDVDs" class="list-list-table-bodyline">
            <div class="list-list-table-cell list-list-table-bodycell list-list-table-number-cell">{{ index + 1 }}</div>
            <!-- タイトル -->
            <RouterLink v-bind:to="{ name: 'detail', params: { propDVD: DVD.id} }" class="list-list-table-cell list-list-table-bodycell  list-list-table-title-cell list-list-table-button" target="_blank" rel="noopener noreferrer">
              {{ DVD.title }}
            </RouterLink>
            <!-- カテゴリー -->
            <div class="list-list-table-cell list-list-table-bodycell list-list-table-category-cell">
              <span v-if="DVD.category === 1" class="list-list-table-category"><img :src="'kabuki.png'" alt="いのうえ歌舞伎" class="list-kabuki"></span>
              <span v-if="DVD.category === 2" class="list-list-table-category"><i class="far fa-grin-squint"></i></span>
              <span v-if="DVD.category === 3" class="list-list-table-category"><i class="fas fa-guitar"></i></span>
            </div>
            <!-- 公演期間 -->
            <div class="list-list-table-cell list-list-table-bodycell list-list-table-duration-cell list-list-table-small-font">
              <span v-if="DVD.duration_from" class="list-list-table-duration">{{ DVD.duration_from }}</span>
              <span v-if="DVD.duration_to" class="list-list-table-connection">~</span>
              <span v-if="DVD.duration_to" class="list-list-table-duration">{{ DVD.duration_to }}</span>
            </div>
            <!-- 公演地 -->
            <div v-if="DVD.locations.length" class="list-list-table-cell list-list-table-bodycell list-list-table-location-cell list-list-table-small-font">
              <span v-for="(location, index) in DVD.locations">
                <span>{{ optionPrefectures[optionPrefectures.findIndex(({value}) => value == location.prefecture)].title  }}</span>
                <span v-if="index != DVD.locations.length - 1">,</span>
              </span>
            </div>
            <div v-else class="list-list-table-cell list-list-table-bodycell list-list-table-location-cell"></div>
            <!-- 戯曲 -->
            <div v-if="DVD.author" class="list-list-table-cell list-list-table-bodycell list-list-table-author-cell">{{ DVD.author }}</div>
            <div v-else class="list-list-table-cell list-list-table-bodycell list-list-table-author-cell"></div>
            <!-- 貸出 -->
            <div class="list-list-table-cell list-list-table-bodycell list-list-table-rent-cell">
              <span v-if="!DVD.rents.length" class="list-list-table-rent green"><i class="far fa-circle"></i></span>
            </div>
          </div> 
        </div>      
      </div>

      <div v-else class="list-non-area">
        DVDは登録されていません。
      </div>
    </div>

    <div v-show="tabList === 2" class="list-grid-area">
      <div v-if="showDVDs.length" class="list-grid-box">
        <div v-for="DVD in showDVDs" class="list-grid-box-block">
          <div class="list-grid-photo">
            <!-- <input type="checkbox" v-if="choice_flag" v-model="choice_ids[DVD.id]"> -->
            <input type="checkbox" v-if="choice_flag">
            <figure v-if="DVD.photos[0]" class="list-grid-photo-wrapper">
              <img
                class="list-grid-photo-image"
                :src="DVD.photos[0].url"
                :alt="DVD.title"
              >
              <RouterLink v-bind:to="{ name: 'detail', params: { propDVD: DVD.id} }" target="_blank" class="list-grid-router" rel="noopener noreferrer"></RouterLink>
            </figure>
            <figure v-else class="list-grid-photo-wrapper">
              <img
                class="list-grid-photo-image"
                :alt="DVD.title"
              >
              <RouterLink v-bind:to="{ name: 'detail', params: { propDVD: DVD.id} }" target="_blank" class="list-grid-router" rel="noopener noreferrer"></RouterLink>
            </figure>
            <div class="list-grid-text-box">
              <!-- タイトル -->
              <RouterLink v-bind:to="{ name: 'detail', params: { propDVD: DVD.id} }" target="_blank" class="list-grid-title">
                {{ DVD.title }}
              </RouterLink>
              <div class="list-grid-category">
                <span v-if="DVD.category === 1" class="list-gred-category"><img :src="'kabuki.png'" alt="いのうえ歌舞伎" class="list-kabuki"></span>
                <span v-if="DVD.category === 2" class="list-gred-category"><i class="far fa-grin-squint"></i></span>
                <span v-if="DVD.category === 3" class="list-gred-category"><i class="fas fa-guitar"></i></span>
              </div>
              <!-- 公演期間 -->
              <div v-if="DVD.duration_from" class="list-grid-duration">
                {{ DVD.duration_from }} <span v-if="DVD.duration_to">~</span> <span v-if="DVD.duration_to">{{ DVD.duration_to }}</span>
              </div>
              <!-- 公演地 -->
              <div v-if="DVD.locations.length" class="list-grid-location">
                <span v-for="(location, index) in DVD.locations">
                  <span>{{ optionPrefectures[optionPrefectures.findIndex(({value}) => value == location.prefecture)].title  }}</span>
                  <span v-if="index != DVD.locations.length -1">,</span>
                </span>
              </div>
              <!-- 戯曲 -->
              <div v-if="DVD.author" class="list-grid-author">
                {{ DVD.author }}
              </div>
              <!-- 貸出 -->
              <div v-if="!DVD.rents.length" class="list-grid-rent green">
                <i class="far fa-circle"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="list-non-area">
        DVDは登録されていません。
      </div>
    </div>
  </div>
</template>

<script>
  import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util';
  import searchDVD from '../components/Search_DVD.vue';
import { fa } from 'vuetify/locale';
  
  export default {
    // このページの上で表示するコンポーネント
    components: {
      searchDVD
    },
    data() {
      return{
        // タブ切り替え
        tabList: 1,
        // 取得するデータ
        DVDs: [],
        // 表示するデータ
        showDVDs: [],
        // 検索/並び替え
        custom: {
          sort: null, // null:reset
          mode: 0,
          rent: false,
          format: false,
          title: null,
          category: null,
          duration: null,
          theater: null,
          author: null,
          costumer: null,
          lyricist: null,
          choreo: null,
          direcotr: null,
          players: null,
          roles: null,
          rent: null
        },
        // コンポーネント
        showContent_search: false,
        // 選択肢
        optionPrefectures : [
          { title:'北海道', value :1 },
          { title:'青森県', value :2 },
          { title:'岩手県', value :3 },
          { title:'宮城県', value :4 },
          { title:'秋田県', value :5 },
          { title:'山形県', value :6 },
          { title:'福島県', value :7 },
          { title:'茨城県', value :8 },
          { title:'栃木県', value :9 },
          { title:'群馬県', value :10 },
          { title:'埼玉県', value :11 },
          { title:'千葉県', value :12 },
          { title:'東京都', value :13 },
          { title:'神奈川県', value :14 },
          { title:'新潟県', value :15 },
          { title:'富山県', value :16 },
          { title:'石川県', value :17 },
          { title:'福井県', value :18 },
          { title:'山梨県', value :19 },
          { title:'長野県', value :20 },
          { title:'岐阜県', value :21 },
          { title:'静岡県', value :22 },
          { title:'愛知県', value :23 },
          { title:'三重県', value :24 },
          { title:'滋賀県', value :25 },
          { title:'京都府', value :26 },
          { title:'大阪府', value :27 },
          { title:'兵庫県', value :28 },
          { title:'奈良県', value :29 },
          { title:'和歌山県', value :30 },
          { title:'鳥取県', value :31 },
          { title:'島根県', value :32 },
          { title:'岡山県', value :33 },
          { title:'広島県', value :34 },
          { title:'山口県', value :35 },
          { title:'徳島県', value :36 },
          { title:'香川県', value :37 },
          { title:'愛媛県', value :38 },
          { title:'高知県', value :39 },
          { title:'福岡県', value :40 },
          { title:'佐賀県', value :41 },
          { title:'長崎県', value :42 },
          { title:'熊本県', value :43 },
          { title:'大分県', value :44 },
          { title:'宮崎県', value :45 },
          { title:'鹿児島県', value :46 },
          { title:'沖縄県', value :47 }]
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
      // DVD一覧を取得
      async fetchDVDs () {
        const response = await axios.get('/api/DVDs_all');
  
        if (response.status !== 200) {
          this.$store.commit('error/setCode', response.status);
          return false;
        }

        this.DVDs = response.data; // オリジナルデータ
        this.showDVDs = JSON.parse(JSON.stringify(this.DVDs));
        
        // if(this.custom_sort || this.custom_name.input !== null || this.custom_refine){
        //   await this.closeModal_searchProp(this.custom_sort, this.custom_name, this.custom_refine);
        // }else{
        //   this.sort_Standard(this.showProps);
        // }

        this.sortStandard(this.showDVDs);
      },

      sortStandard(array){
        if(array === 'reset'){
          this.showDVDs = JSON.parse(JSON.stringify(this.DVDs));
          array = this.showDVDs;
          this.custom = {
            sort: null,
            mode: 1,
            rent: false,
            format: false,
            title: null,
            category: null,
            duration: null,
            theater: null,
            author: null,
            costumer: null,
            lyricist: null,
            choreo: null,
            direcotr: null,
            players: null,
            roles: null
          };
        }

        array.sort((a,b) => {
          return a.duration_from > b.duration_from ? 1 : -1;
        });

        this.showDVDs = array;
      },

      sortTitle(array){
        const regex_str = /[^ァ-ンー]/g; // カタカナ以外
        const regex_number = /[^0-9]/g; // 数字以外
        const regex_alf = /[^A-Z]/g; // アルファベット
        array.sort((a, b) => {
          // kanaで並び替え
          if(a.kana !== b.kana) {
            const a_str = a.kana.replace(regex_str, "");
            const b_str = b.kana.replace(regex_str, "");
            let a_number = a.kana.replace(regex_number, "");
            let b_number = b.kana.replace(regex_number, "");
            const a_alf = a.kana.replace(regex_alf, "");
            const b_alf = b.kana.replace(regex_alf, "");

            if(a_str !== b_str){
              let sort_str = a_str;
              if([...b_str].length < [...a_str].length){
                sort_str = b_str;
              } 
              for(let i=0; i < [...sort_str].length; i++){
                if(a_str.codePointAt(i) !== b_str.codePointAt(i)) {
                  if(a_str.codePointAt(i) > b_str.codePointAt(i)) {
                    return 1;
                  } else if (a_str.codePointAt(i) < b_str.codePointAt(i)) {
                    return -1;
                  }
                }          
              }
            }

            if(a_number !== b_number) {
              if(!a_number){
                a_number = 0;
              }
              if(!b_number){
                b_number = 0;
              }

              if(parseInt(a_number) > parseInt(b_number)) {
                return 1;
              } else if (parseInt(a_number) < parseInt(b_number)) {
                return -1;
              }
            }

            if(a_alf !== b_alf) {
              if(a_alf.codePointAt(0) > b_alf.codePointAt(0)) {
                return 1;
              } else if (a_alf.codePointAt(0) < b_alf.codePointAt(0)){
                return -1;
              } else {
                return 0;
              }
            }
          } else {
            return a.duration_from > b.duration_from ? 1 : -1;
          }
        });

        this.showDVDs = array;
      },

      // エスケープ処理
      h(unsafeText){
        if(typeof unsafeText !== 'string'){
            return unsafeText;
        }
        return unsafeText.replace(
          /[&'`"<>]/g, 
          function(match) {
            return {
              '&': '&amp;',
              "'": '&#x27;',
              '`': '&#x60;',
              '"': '&quot;',
              '<': '&lt;',
              '>': '&gt;',
            }[match]
          } 
        );
      },

      // 検索カスタムのモーダル表示 
      openModal_searchDVD (number) {
        this.showContent_search = true;
        this.postSearch = number;
      },
      // 検索カスタムのモーダル非表示
      // 検索/並び替え
      async closeModal_searchDVD(sort, mode, rent, format, title, category, duration, theater, author, costumer, lyricist, choreo, direcotr, players, roles) {
        this.showContent_search = false;
        this.custom.sort = sort;
        if(rent || format || title || category || theater || author || costumer || lyricist || choreo || direcotr || players || roles) {
          let arrayFromRent = JSON.parse(JSON.stringify(this.DVDs));
          let arrayFromFormat = JSON.parse(JSON.stringify(this.DVDs));
          let arrayFromTitle = new Array();
          let arrayFromCategory = new Array();
          let arrayFromDuration = new Array();
          let arrayFromTheater = new Array();
          let arrayFromAuthor = new Array();
          let arrayFromCostumer = new Array();
          let arrayFromLyricist = new Array();
          let arrayFromChoreo = new Array();
          let arrayFromDirector = new Array();
          let arrayFromPlayers = new Array();
          let arrayFromCharacters = new Array();
          let rentFlag = 0;
          let formatFlag = 0;
          let titleFlag = 0;
          let categoryFlag = 0;
          let durationFlag = 0;
          let theaterFlag = 0;
          let authorFlag = 0;
          let costumerFlag = 0;
          let lyricistFlag = 0;
          let choreoFlag = 0;
          let direcotrFlag = 0;
          let playersFlag = 0;
          let charactersFlag = 0;

          if(sort) {
            this.custom.sort = sort;
          } else {
            this.custom.sort = null;
          }
          
          if(mode) {
            this.custom.mode = mode;
          } else {
            this.custom.mode = 1;
          }
          let DVDs = JSON.parse(JSON.stringify(this.DVDs));

          if(rent) {
            this.custom.rent = true;
            arrayFromRent = DVDs.filter(DVD => DVD.rents.length === 0);
            if(!arrayFromRent.length) {
              rentFlag = 1;
            }
          }

          if(format) {
            this.custom.format = true;
            arrayFromFormat = DVDs.filter(DVD => DVD.format === 1);
            if(!arrayFromFormat.length) {
              formatFlag = 1;
            }
          }

          if(title) {
            this.custom.title = title;
            arrayFromTitle = DVDs.filter(DVD => DVD.title.indexOf(title) > -1 || DVD.kana.indexOf(this.Hira2Kana(title)) > -1);
            if(!arrayFromTitle.length) {
              titleFlag = 1;
            }
          }

          if(category) {
            this.custom.category = category;
            arrayFromCategory = DVDs.filter(DVD => DVD.category === category);
            if(!arrayFromCategory.length) {
              categoryFlag = 1;
            }
          }

          if(duration){
            this.custom.duration = duration;
            arrayFromDuration = DVDs.filter(DVD => DVD.duration_from >= duration.durationFrom && DVD.duration_to <= duration.durationTo);
            if(!arrayFromDuration.length) {
              durationFlag = 1;
            }
          } else {
            arrayFromDuration = JSON.parse(JSON.stringify(this.DVDs));
          }

          if(theater) {
            this.custom.theater = theater;
            arrayFromTheater = DVDs.filter(DVD => DVD.locations ? DVD.locations.some(location => location.theater.includes(theater)) : null);
            if(!arrayFromTheater.length) {
              theaterFlag = 1;
            }
          }

          if(author) {
            this.custom.author = author;
            arrayFromAuthor = DVDs.filter(DVD => DVD.author ? DVD.author.indexOf(author) > -1 : null);
            if(!arrayFromAuthor.length) {
              authorFlag = 1;
            }
          }

          if(costumer) {
            this.custom.costumer = costumer;
            arrayFromCostumer = DVDs.filter(DVD => DVD.costumers ? DVD.costumers.some(setCostumer => setCostumer.name.includes(costumer)) : null);
            if(!arrayFromCostumer.length) {
              costumerFlag = 1;
            }
          }

          if(lyricist) {
            this.custom.lyricist = lyricist;
            arrayFromLyricist = DVDs.filter(DVD => DVD.lyricist ? DVD.lyricist.indexOf(lyricist) > -1 : null);
            if(!arrayFromLyricist.length) {
              lyricistFlag = 1;
            }
          }

          if(choreo) {
            this.custom.choreo = choreo;
            arrayFromChoreo = DVDs.filter(DVD => DVD.choreo ? DVD.choreo.indexOf(choreo) > -1 : null);
            if(!arrayFromChoreo.length) {
              choreoFlag = 1;
            }
          }

          if(direcotr) {
            this.custom.direcotr = direcotr;
            arrayFromDirector = DVDs.filter(DVD => DVD.director ? DVD.director.indexOf(direcotr) > -1 : null);
            if(!arrayFromDirector.length) {
              direcotrFlag = 1;
            }
          }

          if(players) {
            const playersList = players.split(/[/|" "|"　"|,]/);
            arrayFromPlayers = DVDs.filter(DVD => DVD.roles ? DVD.roles.some(role => playersList.some(player => role.player.includes(player))) : null);
            if(!arrayFromPlayers.length) {
              playersFlag = 1;
            }
          }

          if(roles) {
            const rolesList = roles.split(/[/|" "|"　"|,]/);
            arrayFromCharacters = DVDs.filter(DVD => DVD.roles ? DVD.roles.some(role => rolesList.some(character => role.role.includes(character))) : null);
            if(!arrayFromCharacters.length) {
              charactersFlag = 1;
            }
          }

          if(mode) {
            // and
            if(rentFlag || formatFlag || titleFlag || durationFlag || categoryFlag || theaterFlag || authorFlag || costumerFlag || lyricistFlag || choreoFlag || playersFlag || direcotrFlag) {
              // 一つでも該当DVDがない条件があった
              this.showDVDs = [];
            } else {
              let array1 = this.extraAndArray(arrayFromRent, arrayFromFormat);
              let array2 = this.extraAndArray(array1, arrayFromTitle);
              let array3 = this.extraAndArray(array2, arrayFromDuration);
              let array4 = this.extraAndArray(array3, arrayFromCategory);
              let array5 = this.extraAndArray(array4, arrayFromTheater);
              let array6 = this.extraAndArray(array5, arrayFromAuthor);
              let array7 = this.extraAndArray(array6, arrayFromCostumer);
              let array8 = this.extraAndArray(array7, arrayFromLyricist);
              let array9 = this.extraAndArray(array8, arrayFromChoreo);
              let array10 = this.extraAndArray(array9, arrayFromPlayers);
              let array11 = this.extraAndArray(array10, arrayFromDirector);

              this.showDVDs = array11;
            }            
          } else {
            // or
            let array = [...new Set(arrayFromTitle.concat(arrayFromCategory, arrayFromTheater, arrayFromAuthor, arrayFromCostumer, arrayFromCharacters, arrayFromChoreo, arrayFromDirector, arrayFromPlayers, arrayFromCharacters))];
            
            let array2 = [];
            let array3 = [];
            let array4 = [];
            if(array.length) {
              array2 = this.extraAndArray(array, arrayFromRent);
            }
            
            if(array2.length) {
              array3 = this.extraAndArray(array2, arrayFromFormat);
            }

            if(array3.length) {
              array4 = this.extraAndArray(array3, arrayFromDuration);
            }            

            this.showDVDs = array4;
          }
        }

        if(sort === "title") {
          this.sortTitle(this.showDVDs);
        } else {
          this.sortStandard(this.showDVDs);
        }
      },

      // and用
      extraAndArray(firstArray, secondArray) {
        let array = new Array();
        let newArray = firstArray.concat(secondArray);
        if(firstArray.length > 0 && secondArray.length > 0) {
          let dupIdxArr = []
          newArray.filter((arr, index) => {
            newArray.filter((arr2, index2) => {
              if (index !== index2 && arr.id === arr2.id) {
                // 重複分のidを配列に追加
                dupIdxArr.push(arr.id)
              }
            });
          });
          dupIdxArr = [...new Set(dupIdxArr)];
          dupIdxArr.forEach(id => {
            array.push(newArray.find(arr => id === arr.id));
          });
          newArray = array;
        }

        return newArray;
      },

      // 文字列内のひらがなをカタカナに変換
      Hira2Kana(str) {
        return str.replace(/[\u3041-\u3096]/g, ch =>
          String.fromCharCode(ch.charCodeAt(0) + 0x60)
        );
      },

      // 表示切替
      switchDisplay() {
        if(this.tabList === 1){
          this.tabList = 2;
        }else{
          this.tabList = 1;
        }
      }
    }
  }  
</script>