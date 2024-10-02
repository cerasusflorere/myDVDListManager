<template>
    <div class='overlay overlay-custom' @click.self="$emit('close')">
      <div ref="content_search" class="search-area">
        <div class="search-button-area">
          <!-- 閉じるボタン -->
          <div class="search-close-button-area">
            <button type="button" class="search-close-button" @click="$emit('close')"><i class="fa-solid fa-xmark fa-fw"></i></button>
          </div>

          <!-- リセットボタン -->
          <div class="search-reset-button-area">
            <button type="button" class="search-reset-button" @click="resetSearchDVD"><i class="fas fa-undo-alt fa-fw"></i></button>
          </div>
        </div>

        <form class="search-set-area"  @submit.prevent="searchDVD">
          <!-- 並び替え -->
          <div class="search-sort-area">
            <span class="search-header"><i class="fas fa-sort fa-fw"></i>並び替え</span>
            <div class="search-sort-set-area">
              <input type="radio" id="search_sort_duration" v-model="searchContentDVD.sort" value="duration">
              <label for="search_sort_duration">公演期間順</label>       

              <input type="radio" id="search_sort_title" v-model="searchContentDVD.sort" value="title">
              <label for="search_sort_title">タイトル順</label>
            </div>
          </div>

          <!-- 絞り込み -->
          <div class="search-refine-area">
            <span class="search-header"><i class="fas fa-filter fa-fw"></i>絞り込み</span>
            <div class="search-refine-set-area">
              <!-- 貸出可能 -->
              <div class="search-refine-rent-area">
                <input type="checkbox" id="search_rent" v-model="searchContentDVD.refine.rent" class="search-refine-rent-check">
                <label for="search_rent" class="search-refine-rent-label">貸出可能のみ</label>
              </div>

              <!-- DVD -->
              <div class="search-refine-rent-area">
                <input type="checkbox" id="search_format" v-model="searchContentDVD.refine.format" class="search-refine-rent-check">
                <label for="search_format" class="search-refine-rent-label">DVDのみ</label>
              </div>
            </div>
            <div class="search-refine-set-area">
              <!-- タイトル -->
              <div class="search-refine-title-area">
                <div class="search-header">タイトル</div>
                <input type="text" class="search-refine-title" v-model="searchContentDVD.refine.title">
              </div>

              <div class="search-refine-category-area">
                <div class="search-header">カテゴリー</div>
                <select class="search-refine-category" v-model="searchContentDVD.refine.category">
                  <option value=0>すべて</option>
                  <option v-for="category in optionCategories" 
                    :value="category.value">
                    {{ category.title }}
                  </option>
                </select>
              </div>

              <!-- 公演期間 -->
              <div class="search-refine-duration-area">
                <div class="search-header">公演期間</div>

                <div class="search-refine-duration-set-area">
                  <div class="search-refine-duration-date-area">
                    <select v-model="searchContentDVD.refine.durationFrom.year">
                      <option v-for="(year) in yearList" :value="year">
                        {{ year }}
                      </option>
                    </select>
                    <span class="search-header">年</span>
                    <select v-model="searchContentDVD.refine.durationFrom.month">
                      <option v-for="(month) in monthList" :value="month">
                        {{ month }}
                      </option>
                    </select>
                    <span class="search-header">月</span>

                    <span class="search-header">~</span>

                    <select v-model="searchContentDVD.refine.durationTo.year">
                      <option v-for="(year) in yearList" :value="year">
                        {{ year }}
                      </option>
                    </select>
                    <span class="search-header">年</span>
                    <select v-model="searchContentDVD.refine.durationTo.month">
                      <option v-for="(month) in monthList" :value="month">
                        {{ month }}
                      </option>
                    </select>
                    <span class="search-header">月</span>
                  </div>

                  <div class="search-refine-duration-check-area">
                    <input type="checkbox" id="search_refine_durationFrom" class="search-refine-duration-no" v-model="searchContentDVD.refine.durationFrom.no">
                    <label for="search_refine_durationFrom">afterなし</label>
                    
                    <input type="checkbox" id="search_refine_durationTo" class="search-refine-duration-no" v-model="searchContentDVD.refine.durationTo.no">
                    <label for="search_refine_durationTo">beforeなし</label>                
                  </div>
                </div>              
              </div>

              <div class="search-refine-choice-area">
                <!-- 劇場 -->
                <div class="search-refine-author-area">
                  <div class="search-header">
                    劇場
                  </div>
                  <select class="search-refine-author" v-model="searchContentDVD.refine.theater">
                    <option v-for="(theater) in optionTheaters" :value="theater">
                      {{ theater }}
                    </option>
                  </select>
                </div>

                <!-- 戯曲 -->
                <div class="search-refine-author-area">
                  <div class="search-header">
                    戯曲
                  </div>
                  <select class="search-refine-author" v-model="searchContentDVD.refine.author">
                    <option v-for="(author) in optionAuthors" :value="author">
                      {{ author }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="search-refine-choice-area">
                <!-- 衣装 -->
                <div class="search-refine-author-area">
                  <div class="search-header">
                    衣装
                  </div>
                  <select class="search-refine-author" v-model="searchContentDVD.refine.costumer">
                    <option v-for="costumer in optionCostumers" :value="costumer">
                      {{ costumer }}
                    </option>
                  </select>
                </div>
                
                <!-- 作詞 -->
                <div class="search-refine-author-area">
                  <div class="search-header">
                    作詞
                  </div>
                  <select class="search-refine-author" v-model="searchContentDVD.refine.lyricist">
                    <option v-for="lyricist in optionLyricists" :value="lyricist">
                      {{ lyricist }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="search-refine-choice-area">
                <!-- 振付 -->
                <div class="search-refine-author-area">
                  <div class="search-header">
                    振付
                  </div>
                  <select class="search-refine-author" v-model="searchContentDVD.refine.choreo">
                    <option v-for="choreo in optionChoreos" :value="choreo">
                      {{ choreo }}
                    </option>
                  </select>
                </div>
                
                <!-- ゲキ×シネ監督 -->
                <div class="search-refine-author-area">
                  <div class="search-header">
                    ゲキ×シネ監督
                  </div>
                  <select class="search-refine-author" v-model="searchContentDVD.refine.director">
                    <option v-for="director in optionDirectors" :value="director">
                      {{ director }}
                    </option>
                  </select>
                </div>
              </div>           

              <!-- 出演者 -->
              <div class="search-refine-players-area">
                <div class="search-header">出演者</div>
                <textarea class="search-refine-input" v-model="searchContentDVD.refine.players"></textarea>
              </div>

              <!-- 登場人物 -->
              <div class="search-refine-roles-area">
                <div class="search-header">登場人物</div>
                <textarea class="search-refine-input" v-model="searchContentDVD.refine.roles"></textarea>
              </div>
            </div>

            <div class="search-refine-mode-area">
              <div class="search-header">モード</div>
              <div class="search-refine-mode-set-area">
                <input type="radio" id="search_refine_mode_and" class="search-refine-mode" v-model="searchContentDVD.refine.mode" value=1>
                <label for="search_refine_mode_and">and</label>

                <input type="radio" id="search_refine_mode_no" class="search-refine-mode" v-model="searchContentDVD.refine.mode" value=0>
                <label for="search_refine_mode_no">or</label>
              </div>            
            </div>
          </div>
        
          <!--- 送信ボタン -->
          <div class="search-submit-button-area">
            <button type="submit" class="search-submit-button"><i class="fas fa-search fa-fw"></i>検索</button>
          </div>
          
        </form>
      </div>
    </div>
  </template>
  
  <script>
    import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util';
  
    export default {
      // モーダルとして表示
      name: 'searchDVD',
      props: {
        postSearch: {
          type: Number,
          required: true
        }
      },
      data() {
        return{
          // 検索
          yearList: [],
          monthList: [],
          // 劇場リスト
          optionTheaters: [],
          // 戯曲家リスト
          optionAuthors: [],
          // 衣装リスト
          optionCostumers: [],
          // 作詞リスト
          optionLyricists: [],
          // 振付リスト
          optionChoreos: [],
          // ゲキ×シネ監督リスト
          optionDirectors: [],
          // 今日
          today: new Date(),
          // 検索
          searchContentDVD: {
            sort: "duration",
            refine: {
              rent: false,
              format: false,
              title: null,
              category: null,
              durationFrom: {
                year: null,
                month: null,
                no: true
              },
              durationTo: {
                year: null,
                month: null,
                no: true
              },
              theater: null,
              author: null,
              costumer: null,
              lyricist: null,
              choreo: null,
              director: null,
              players: null,
              roles: null,
              mode: 0
            }
          },

          // カテゴリー
          optionCategories: [
            { title: 'いのうえ歌舞伎', value: 1 },
            { title: 'ネタモノ', value: 2 },
            { title: '音もの', value: 3},
            { title: 'その他', value: 4}
          ]
        }
      },
      watch: {
        $route: {
          async handler () {
            await this.set();
            await this.fetchTheaters();
            await this.fetchAuthors();
            await this.fetchCostumers();
            await this.fetchLyricists();
            await this.fetchChoreos();
            await this.fetchDirectors();
          },
          immediate: true
        }
      },
      methods: {
        // 初期セット
        async set() {
          for(let i = 1990; i <= this.today.getFullYear(); i++) {
            this.yearList.push(i);
          }
          for(let i=1; i <=12; i++) {
            this.monthList.push(i);
          }
        },

        // 劇場を取得
        async fetchTheaters() {
          const response = await axios.get('/api/theater');

          if(response.status !== 200) {
            this.$store.commit('error/setCode', response.status);
            return false;
          }

          this.optionTheaters.push('尼崎ピッコロシアター中ホール');
          response.data.forEach(data => {
            if(data.theater && data.theater !== '尼崎ピッコロシアター中ホール') {
              this.optionTheaters.push(data.theater);
            }
          });
        },

        // 戯曲を取得
        async fetchAuthors () {
          const response = await axios.get('/api/author');
  
          if(response.status !== 200) {
            this.$store.commit('error/setCode', response.status);
            return false;
          }
  
          this.optionAuthors.push('中島かずき');
          response.data.forEach(data => {
            if(data.author && data.author != '中島かずき') {
              this.optionAuthors.push(data.author);
            }
          });
        },

        // 衣装を取得
        async fetchCostumers () {
          const response = await axios.get('/api/costumer');

          if(response.status !== 200) {
            this.$store.commit('error/setCode', response.status);
            return false;
          }

          this.optionCostumers.push('竹田団吾');
          response.data.forEach(data => {
            if(data.name && data.name != '竹田団吾') {
              this.optionCostumers.push(data.name);
            }
          });
        },

        // 作詞を取得
        async fetchLyricists () {
          const response = await axios.get('/api/lyricist');

          if (response.status !== 200) {
            this.$store.commit('error/setCode', response.status);
            return false;
          }

          this.optionLyricists.push('森雪之丞');
          response.data.forEach(data => {
            if(data.lyricist && data.lyricist != '森雪之丞') {
              this.optionLyricists.push(data.lyricist);
            }
          });
        },

        // 振付を取得
        async fetchChoreos () {
          const response = await axios.get('/api/choreo');

          if (response.status !== 200) {
            this.$store.commit('error/setCode', response.status);
            return false;
          }

          this.optionChoreos.push('川崎悦子');
          response.data.forEach(data => {
            if(data.choreo && data.choreo != '川崎悦子') {
              this.optionChoreos.push(data.choreo);
            }
          });
        },

        // ゲキ×シネ監督を取得
        async fetchDirectors () {
          const response = await axios.get('/api/director');

          if (response.status !== 200) {
            this.$store.commit('error/setCode', response.status);
            return false;
          }

          response.data.forEach(data => {
            if(data.director) {
              this.optionDirectors.push(data.director);
            }
          });
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
  
        // 並び替えか絞り込みか // 全部一致か一部一致か
        searchDVD() {
          let duration = {durationFrom: "1980-01-01", durationTo: this.today.toLocaleDateString('sv-SE')};
          const days = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
          if(!this.searchContentDVD.refine.durationFrom.no && this.searchContentDVD.refine.durationFrom.year) {
            duration.durationFrom = this.searchContentDVD.refine.durationFrom.year + "-";
            if(this.searchContentDVD.refine.durationFrom.month > 0 && this.searchContentDVD.refine.durationFrom.month < 13) {
              duration.durationFrom += this.searchContentDVD.refine.durationFrom.month + "-01";
            } else {
              duration.durationFrom += "01-01";
            }
          }

          if(!this.searchContentDVD.refine.durationTo.no && this.searchContentDVD.refine.durationTo.year) {
            duration.durationTo = this.searchContentDVD.refine.durationTo.year + "-";
            if(this.searchContentDVD.refine.durationTo.month > 0 && this.searchContentDVD.refine.durationTo.month < 13) {
              if(this.searchContentDVD.refine.durationTo.month != 2 || (this.searchContentDVD.refine.durationTo.year % 4 != 0 )) {
                duration.durationTo += this.searchContentDVD.refine.durationTo.month + "-" + days[this.searchContentDVD.refine.durationTo.month-1];
              } else {
                duration.durationTo += "02-29";
              }
            } else {
              duration.durationTo += "12-31";
            }
          }

          this.$emit('close', this.searchContentDVD.sort, this.searchContentDVD.refine.mode, this.searchContentDVD.refine.rent, this.searchContentDVD.refine.format, this.searchContentDVD.refine.title, this.searchContentDVD.refine.category, duration, this.searchContentDVD.refine.theater, this.searchContentDVD.refine.author, this.searchContentDVD.refine.costumer, this.searchContentDVD.refine.lyricist, this.searchContentDVD.refine.choreo, this.searchContentDVD.refine.director, this.searchContentDVD.refine.players, this.searchContentDVD.refine.roles);
        },

        // リセット
        resetSearchDVD() {
          this.searchContentDVD = {
            sort: "duration",
            refine: {
              rent: false,
              format: false,
              title: null,
              category: null,
              durationFrom: {
                year: null,
                month: null,
                no: true
              },
              durationTo: {
                year: null,
                month: null,
                no: true
              },
              theater: null,
              author: null,
              costumer: null,
              lyricist: null,
              choreo: null,
              director: null,
              players: null,
              roles: null,
              mode: 0
            }
          };
        }
      }
    }
  </script>