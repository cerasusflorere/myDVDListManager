<template>
  <div class="detail-area">
    <!--- 閲覧/編集 -->
    <div class="detail-show-button-area">
      <button type="button" v-show="tab === 1" class="detail-show-button" @click="alterTab"><i class="fas fa-edit fa-fw"></i>編集</button>
      <button type="button" v-show="tab === 2" class="detail-show-button" @click="alterTab"><i class="fas fa-eye fa-fw"></i>閲覧</button>
      <button type="button" class="detail-show-button" @click="confirmDeleteDVD"><i class="fas fa-trash fa-fw"></i>削除</button>
    </div>

    <div v-show="tab === 1" class="detail-show-area">
      <!-- タイトル -->
      <div class="detail-show-title">{{ DVD.title }}</div>

      <!-- 諸々情報 -->
      <div class="detail-show-info-area">
        <div class="detail-show-info-line">
          <div class="detail-show-info-block">
            <div class="detail-show-info-header" v-if="DVD.category">
              {{ optionCategories[optionCategories.findIndex(({value}) => value == DVD.category)].title }}
            </div>
          </div>

          <div class="detail-show-info-block">
            <div class="detail-show-info-header">公式:</div>
            <div class="detail-show-info-header" v-if="DVD.official"><i class="fas fa-check fa-fw"></i></div>
            <div class="detail-show-info-header" v-else><i class="fas fa-times"></i></div>
          </div>

          <div class="detail-show-info-block">
            <div class="detail-show-info-header">媒体:</div>
            <div class="detail-show-info-header" v-if="DVD.format == 1">DVD</div>
            <div class="detail-show-info-header" v-else>Bluray</div>
          </div>

          <div class="detail-show-info-block">
            <div class="detail-show-info-header">特典:</div>
            <div class="detail-show-info-header" v-if="DVD.special"><i class="fas fa-check fa-fw"></i></div>
            <div class="detail-show-info-header" v-else><i class="fas fa-times"></i></div>
          </div>

          <div class="detail-show-info-block">
            <div class="detail-show-info-header">貸出可否:</div>
            <div class="detail-show-info-header green" v-if="!rentFlag"><i class="far fa-circle"></i></div>
            <div class="detail-show-info-header red" v-else><i class="fas fa-times"></i></div>
          </div> 
        </div>

        <div class="detail-show-info-line" v-if="DVD.url_DVD">
          <div class="detail-show-info-block detail-show-other-flex">
            <div class="detail-show-info-header detail-show-other-width">イーオシ:</div>
            <a :href="DVD.url_DVD" class="detail-show-info-header" target="_blank" rel="noopener noreferrer">{{ DVD.url_DVD }}</a>
          </div>
        </div>

        <div class="detail-show-info-line" v-if="DVD.url_movie">
          <div class="detail-show-info-block detail-show-other-flex">
            <div class="detail-show-info-header detail-show-other-width">ゲキ×シネ:</div>
            <a :href="DVD.url_movie" class="detail-show-info-header" target="_blank" rel="noopener noreferrer">{{ DVD.url_movie }}</a>
          </div>
        </div>

        <div class="detail-show-info-line" v-if="DVD.url_youtube">
          <div class="detail-show-info-block detail-show-other-flex">
            <div class="detail-show-info-header detail-show-other-width">映像:</div>
            <a :href="DVD.url_youtube" class="detail-show-info-header" target="_blank" rel="noopener noreferrer">{{ DVD.url_youtube }}</a>
          </div>
        </div>
      </div>

      <!-- 写真 -->
      <div v-if="DVD.photos.length" class="detail-show-photo-grid-box">
        <div v-for="(photo, index) in DVD.photos" class="detail-show-photo-grid-block">
          <div class="detail-show-photo-grid-photo">
            <figure v-if="photo.url" class="detail-show-photo-grid-photo-wrapper">
              <img
                class="detail-show-photo-grid-photo-image"
                :src="photo.url"
                :alt="index"
              >
              <input type="button" class="detail-show-photo-button" @click="openModal_photo(photo.url)">
            </figure>
          </div>
        </div>
      </div>

      <!-- 公演期間 -->
      <div class="detail-show-duration-area detail-show-other-flex" v-if="DVD.duration_from">
        <div class="detail-show-header detail-show-other-width">公演期間</div>
        <div class="detail-show-duration">
          <div class="detail-show-duration-content" v-if="DVD.duration_from">{{ DVD.duration_from }}</div>
          <div class="detail-show-duration-content" v-if="DVD.duration_to">~</div>
          <div class="detail-show-duration-content" v-if="DVD.duration_to">{{ DVD.duration_to }}</div>
        </div>
      </div>

      <!-- 公演地 -->
      <div class="detail-show-locations-area detail-show-other-flex" v-if="DVD.locations.length">
        <div class="detail-show-header">公演地</div>
        <div class="detail-show-locations-block detail-show-other-width">
          <div class="detail-show-location-area detail-show-other-width" v-for="location in DVD.locations">
            <div class="detail-show-location-content">{{ location.theater }}</div>
            <div class="detail-show-location-content-small" v-if="location.prefecture">
              (@{{ optionPrefectures[optionPrefectures.findIndex(({value}) => value == location.prefecture)].title }})
            </div>
          </div>
        </div>
      </div>

      <!-- 戯曲 -->
      <div class="detail-show-author-area" v-if="DVD.author">
        <div class="detail-show-header">戯曲</div>
        <div class="detail-show-author">{{ DVD.author }}</div>
      </div>

      <!-- 衣装 -->
      <div class="detail-show-author-area" v-if="DVD.costumers.length">
        <div class="detail-show-header">衣装</div>
        <div class="detail-show-costumers-block">
          <div class="detail-show-costumer-area" v-for="costumer in DVD.costumers">
            <div class="detail-show-author">{{ costumer.name }}</div>
          </div>
        </div>
      </div>

      <!-- 作詞 -->
      <div class="detail-show-author-area" v-if="DVD.lyricist">
        <div class="detail-show-header">衣装</div>
        <div class="detail-show-author">{{ DVD.lyricist }}</div>
      </div>

      <!-- 振付 -->
      <div class="detail-show-author-area" v-if="DVD.choreo">
        <div class="detail-show-header">振付</div>
        <div class="detail-show-author">{{ DVD.choreo }}</div>
      </div>

      <!-- ゲキ×シネ監督 -->
      <div class="detail-show-author-area" v-if="DVD.director">
        <div class="detail-show-header">ゲキ×シネ監督</div>
        <div class="detail-show-author">{{ DVD.director }}</div>
      </div>

      <!-- あらすじ -->
      <div class="detail-show-story-area detail-show-other-flex" v-if="DVD.story">
        <div class="detail-show-header detail-show-other-width">あらすじ</div>
        <div class="detail-show-story detail-show-other-width">{{ DVD.story }}</div>
      </div>

      <!-- 配役 -->
      <div class="detail-show-roles-area detail-show-other-flex" v-if="DVD.roles.length">
        <div class="detail-show-header">配役</div>
        <div class="detail-show-roles-block detail-show-other-width">
          <div class="detail-show-role-area" v-for="role in DVD.roles">
            <div class="detail-show-role-role" v-if="role.role">{{ role.role }}:</div>
            <div class="detail-show-role-role" v-else></div>
            <div class="detail-show-role-content" v-if="role.player">{{ role.player }}</div>
          </div>
        </div>
      </div>

      <!-- 感想 -->
      <div class="detail-show-impression-area detail-show-other-flex" v-if="DVD.impression">
        <div class="detail-show-header">感想</div>
        <div class="detail-show-impression detail-show-other-width">{{ DVD.impression }}</div>
      </div>

      <!-- 役感想 -->
      <div class="detail-show-role-impressions-area" v-if="DVD.roleImpressionList.length">
        <div class="detail-show-role-impression-block" v-for="roleImpression in DVD.roleImpressionList">
          <div class="detail-show-role-impression-area">
            <div class="detail-show-role-impression-detail-area">
              <div ref="detail_show_role_impression_headers">【{{ roleImpression.role }} <span><span class="detail-show-role-impression-detail-small">(by {{ roleImpression.player }})</span>】</span></div>
              <div class="detail-show-role-impression-detail-impression">{{ roleImpression.impression }}</div>
            </div>
            <div class="detail-show-role-impression-photo">
              <figure v-if="roleImpression.photos[0]" class="detail-show-role-impression-photo-wrapper">
                <img
                  class="detail-show-role-impression-photo-image"
                  :src="roleImpression.photos[0].url"
                  :alt="roleImpression.role"
                >
                <input type="button" class="detail-show-photo-button" @click="openModal_photo(roleImpression.photos[0].url)">
              </figure>
            </div>
          </div>
        </div>
      </div>

      <!-- 歴史 -->
      <div class="detail-show-others-area" v-if="DVD.histories.length">
        <div class="detail-show-header">歴史</div>
        <div class="detail-show-others-block">
          <div v-for="history in DVD.histories" class="detail-show-other-area detail-show-other-flex">
            <div class="detail-show-header detail-show-other-width" v-if="history.title">{{ history.title }}</div>
            <div class="detail-show-other-area detail-show-other-width">{{ history.history }}</div>
          </div>
        </div>
      </div>

      <!-- 歌 -->
      <div class="detail-show-others-area" v-if="DVD.songs.length">
        <div class="detail-show-header">歌</div>
        <div class="detail-show-others-block">
          <div v-for="song in DVD.songs" class="detail-show-song-area">
            <div ref="detail_song_titles" class="detail-show-singer-common detail-show-singer-2">
              <div class="detail-show-singer-common">
                【
              </div>
              <div class="detail-show-singer-common detail-show-singer-5">
                <div class="detail-show-singer-common detail-show-singer-2">
                  {{ song.title }}
                  <div v-if="song.singers.length" class="detail-show-singer-common">/</div>
                </div>

                <div class="detail-show-singer-common detail-show-singer-2">                
                  <div v-if="song.singers.length" class="detail-show-singer-common">
                    <div v-for="(singer, index) in song.singers" class="detail-show-singer-common">
                      <div v-if="singer.role_id" class="detail-show-singer-common detail-show-singer-2">
                        {{ singer.role.role }}
                        <div class="detail-show-singer-small">
                          (by {{ singer.role.player }})
                        </div>
                      </div>
                      <div v-else-if="singer.role_group_id">
                        {{ singer.role_group.name }}
                      </div>
                      <div v-else>
                        {{ singer.name }}
                      </div>

                      <div v-if="index !== song.singers.length - 1">・</div>
                    </div>
                  </div> 
                  <div>】</div> 
                </div>        
              </div>
            </div>
            <div class="detail-show-song-impression" v-if="song.impression">{{ song.impression }}</div>
          </div>
        </div>
      </div>

      <!-- その他 -->
      <div class="detail-show-others-area detail-show-other-flex" v-if="DVD.others.length">
        <div class="detail-show-header detail-show-other-width">その他</div>
        <div class="detail-show-others-block">
          <div v-for="other in DVD.others" class="detail-show-other-area detail-show-other-flex">
            <div class="detail-show-header detail-show-other-width" v-if="other.title">{{ other.title }}</div>
            <div class="detail-show-other-area detail-show-other-width" v-if="other.impression">{{ other.impression }}</div>
          </div>
        </div>
      </div>

      <!-- 貸す -->
      <div class="detail-show-rents-area detail-show-other-flex" v-if="DVD.rents.length">
        <div class="detail-show-header detail-show-other-width">貸出記録</div>
        <div class="detail-show-rents-block">
          <div class="detail-show-rent-area" v-for="rent in DVD.rents">
            <div class="detail-show-rent-name">{{ rent.name }}</div>
            <div class="detail-show-rent-start">{{ rent.start_date }}</div>
            <div class="detail-show-rent-flag" v-if="rent.flag"><i class="fas fa-check fa-fw"></i></div>
          </div>
        </div>        
      </div>
    </div>

    <!-- 編集 -->
    <div v-show="tab === 2" class="detail-edit-area">
      <form @submit.prevent="confirmEditData">
        <div class="add-block">
          <div class="add-block-1">
            <!-- タイトル -->
            <div class="add-area add-title-area">
              <div class="add-header">
                タイトル
              </div>
              <div class="add-title-kana-area">
                <input type="text" id="detail_title" v-model="editDVD.title" class="add-title" placeholder="タイトル" @input="getTitle" required>
                <input type="text" v-model="editDVD.kana" class="add-title add-title-kana" placeholder="タイトル" required>
              </div>
                
            </div>

            <!-- 公演期間 -->
            <div class="add-area add-duration-area">
              <div class="add-header">
                公演期間
              </div>
              <div class="add-duration-input-area">
                <input type="date" v-model="editDVD.duration_from" class="add-duration"> 
                <div class="add-duration-conection">
                    ~
                </div>
                <input type="date" v-model="editDVD.duration_to" class="add-duration"> 
              </div>
            </div>

            <!-- 公演場所 -->
            <div class="add-area add-location-area">
              <div class="add-header">
                公演場所
              </div>
              
              <div class="add-locations-button-area">
                <draggable v-model="editDVD.locations" group="locations" item-key="key" tag="section" class="add-locations">
                  <!-- 1セット -->
                  <template #item="{element : location}">
                    <div class="add-location">
                      <select class="add-location-prefecture" v-model="location.prefecture">
                        <option value="">選択</option>
                        <option v-for="prefecture in optionPrefectures" 
                          :value="prefecture.value" :key="prefecture.value">
                          {{ prefecture.title }}
                        </option>
                      </select>
                      <input type="text" class="add-location-theater" v-model="location.theater">
                    </div>
                  </template>                    
                </draggable>

                <!-- フォームボタン -->
                <div class="add-add-minus-button-area">
                  <div ref="detail_minus_button_area_locations_form" class="add-minus-button-area">
                    <button type="button" class="add-add-button" @click="minusLocationForm">
                      <div class="add-add-button-icon">
                        <i class="fa-solid fa-minus"></i>
                      </div>
                    </button>
                  </div>
                  <div ref="detail_add_button_area_locations_form" class="add-add-button-area">
                    <button type="button" class="add-add-button" @click="plusLocationForm">
                      <div class="add-add-button-icon">
                        <i class="fa-solid fa-plus"></i>
                      </div>
                    </button>
                  </div>
                </div>
              </div>
                
            </div>

            <!-- 感想 -->
            <div class="add-area add-impression-area">
              <div class="add-header">
                感想
              </div>
              <textarea v-model="editDVD.impression" class="add-impression" placeholder="どうだった？"></textarea>
            </div>

            <!-- あらすじ -->
            <div class="add-area add-story-area">
              <div class="add-header">
                あらすじ
              </div>
              <textarea v-model="editDVD.story" class="add-story" placeholder="あらすじ"></textarea>
            </div>

            <!-- 脚本 -->
            <div class="add-area add-author-area">
              <div class="add-header">
                戯曲
              </div>
              <input type="text" v-model="editDVD.author" class="add-author">
            </div>

            <!-- 衣装 -->
            <div class="add-area add-author-area">
              <div class="add-header">
                衣装
              </div>

              <div class="add-costumers-button-block">
                <!-- 中身 -->
                <div class="add-costumers-bodyblock">
                  <draggable v-model="editDVD.costumers" group="costumers" item-key="key" tag="section" class="add-costumers-costumerline">
                    <!-- 1セット -->
                    <template #item="{element : costumer}">
                      <div class="add-costumers-bodyline">
                        <div class="add-costumers-cell add-costumers-body-cell">
                          <input type="text" class="add-author" v-model="costumer.name">
                        </div>
                      </div>
                    </template>
                  </draggable>
                </div>

                <!-- フォームボタン -->
                <div class="add-add-minus-button-area">
                  <div ref="detail_minus_button_area_costumers_form" class="add-minus-button-area" style="visibility: hidden">
                    <button type="button" class="add-add-button" @click="minusCostumerForm">
                      <div class="add-add-button-icon">
                        <i class="fa-solid fa-minus"></i>
                      </div>
                    </button>
                  </div>
                  <div ref="detail_add_button_area_costumers_form" class="add-add-button-area">
                    <button type="button" class="add-add-button" @click="plusCostumerForm">
                      <div class="add-add-button-icon">
                        <i class="fa-solid fa-plus"></i>
                      </div>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- 作詞 -->
            <div class="add-area add-author-area">
              <div class="add-header">
                作詞
              </div>
              <input type="text" v-model="editDVD.lyricist" class="add-author">
            </div>

            <!-- 振付 -->
            <div class="add-area add-author-area">
              <div class="add-header">
                振付
              </div>
              <input type="text" v-model="editDVD.choreo" class="add-author">
            </div>

            <!-- ゲキ×シネ監督 -->
            <div class="add-area add-author-area">
              <div class="add-header">
                ゲキ×シネ監督
              </div>
              <input type="text" v-model="editDVD.director" class="add-author">
            </div>
            
            <!-- 出演者纏めて入力 -->
            <div class="add-area add-players-all-area">
              <div class="add-header add-header-players-all">
                出演者
              </div>

              <input type="text" v-model="playersAll" class="add-players-all">

              <button type="button" class="add-players-all-button" @click="getAllPlayers">反映</button>
            </div>

            <!-- 配役と分類 -->
            <div class="add-area add-players-groups-area">
              <!-- 配役 -->
              <div class="add-players-area">
                <div class="add-header add-header-players-groups">
                  配役
                </div>

                <div class="add-players-button-block">
                  <!-- 表 -->
                  <div class="add-players-box">
                    <!-- ヘッダー -->
                    <div class="add-players-headerline">
                      <div class="add-players-cell add-players-header-cell add-players-cell-group">
                        分類
                      </div>
                      <div class="add-players-cell add-players-header-cell add-players-cell-role">
                        役名
                      </div>
                      <div class="add-players-cell add-players-header-cell add-players-cell-player">
                        役者
                      </div>
                      <div class="add-players-cell add-players-header-cell add-players-cell-member">
                        劇団員
                      </div>
                    </div>

                    <!-- 中身 -->
                    <div class="add-players-bodyblock">
                      <draggable v-model="editDVD.playerList" group="playerList" item-key="key" tag="section" @end="endMovePlayer">
                        <!-- 1セット -->
                        <template #item="{element : player}">
                          <div class="add-players-playerline">
                            <div class="add-players-cell add-players-line-cell add-players-cell-group">
                              <select class="add-players-input add-players-input-text add-players-group" v-model="player.group_key">
                                <option value="">選択</option>
                                <option v-for="group in optionGroups" 
                                  :value="group.key" :key="group.key">
                                  {{ group.name }}
                                </option>
                              </select>
                            </div>
                            <div class="add-players-cell add-players-line-cell add-players-cell-role">
                              <input type="text" class="add-players-input add-players-input-text add-players-role" v-model="player.role" @input="getRole(player.key)">
                            </div>
                            <div class="add-players-cell add-players-line-cell add-players-cell-player">
                              <input type="text" class="add-players-input add-players-input-text add-players-player" v-model="player.player">
                            </div>
                            <div class="add-players-cell add-players-line-cell add-players-cell-member">
                              <input type="checkbox"  class="add-players-input add-players-member" v-model="player.member">
                            </div>
                          </div>
                        </template>
                      </draggable>                        
                    </div>
                      
                      
                  </div>

                  <!-- フォームボタン -->
                  <div class="add-add-minus-button-area">
                    <div ref="detail_minus_button_area_players_form" class="add-minus-button-area" style="visibility: hidden">
                      <button type="button" class="add-add-button" @click="minusPlayerForm">
                        <div class="add-add-button-icon">
                          <i class="fa-solid fa-minus"></i>
                        </div>
                      </button>
                    </div>
                    <div ref="detail_add_button_area_players_form" class="add-add-button-area">
                      <button type="button" class="add-add-button" @click="plusPlayerForm">
                        <div class="add-add-button-icon">
                          <i class="fa-solid fa-plus"></i>
                        </div>
                      </button>
                    </div>
                  </div>
                    
                </div>
              </div>

              <!-- 分類 -->
              <div class="add-groups-area">
                <div class="add-header add-header-players-groups">
                  分類
                </div>

                <div class="add-groups-button-block">
                  <!-- 表 -->
                  <div class="add-groups-box">
                    <!-- ヘッダー -->
                    <div class="add-groups-headerline">
                      <div class="add-groups-header-cell add-groups-cell-group">
                        分類名
                      </div>
                    </div>

                    <!-- 中身 -->
                    <div class="add-groups-bodyblock">
                      <draggable v-model="editDVD.groups" group="groups" item-key="key" tag="section" @end="endMoveGroup">
                        <!-- 1セット -->
                        <template #item="{element : group}" class="add-groups-groupline">
                          <div class="add-groups-line-cell add-groups-cell-group">
                            <input type="text" class="add-groups-group" v-model="group.name" @input="getGroup(group.key)">
                          </div>
                        </template>
                      </draggable>
                    </div>
                      
                  </div>

                  <!-- フォームボタン -->
                  <div class="add-add-minus-button-area">
                    <div ref="detail_minus_button_area_groups_form" class="add-minus-button-area" style="visibility: hidden">
                      <button type="button" class="add-add-button" @click="minusGroupForm">
                        <div class="add-add-button-icon">
                          <i class="fa-solid fa-minus"></i>
                        </div>
                      </button>
                    </div>
                    <div ref="detail_add_button_area_groups_form" class="add-add-button-area" style="visibility: hidden">
                      <button type="button" class="add-add-button" @click="plusGroupForm">
                        <div class="add-add-button-icon">
                          <i class="fa-solid fa-plus"></i>
                        </div>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 役感想 -->
            <div class="add-area add-role-impressions-area">
              <!-- 表 -->
              <div class="add-role-impressions-box">
                <!-- ヘッダー -->
              <div class="add-role-impressions-headerline">
                  <div class="add-roles-impressions-cell add-role-impressions-header-cell add-role-impressions-cell-role">
                    役名
                  </div>
                  <div class="add-roles-impressions-cell add-role-impressions-header-cell add-role-impressions-cell-impression">
                    感想
                  </div>
                  <div class="add-roles-impressions-cell add-role-impressions-header-cell add-role-impressions-cell-photo">
                    写真
                  </div>
                </div>

                <!-- 中身 -->
                <div id="add_role_impressions_bodyblock" class="add-role-impression-bodyblock">
                  <section v-for="(roleImpression, index) in editDVD.roleImpressionList" :key="index">
                    <!-- 1セット -->
                    <div class="add-role-impressions-bodyline">
                      <div class="add-roles-impressions-cell add-role-impressions-body-cell add-role-impressions-cell-role">
                        <select class="add-role-impressions-input add-role-impressions-role" v-model="roleImpression.role_key" @change="chooseRole(index)">
                          <option value="">選択</option>
                          <option v-for="role in optionRoles" 
                            :value="role.key">
                            {{ role.role }}
                          </option>
                        </select>
                      </div>
                      <div class="add-roles-impressions-cell add-role-impressions-body-cell add-role-impressions-cell-impression">
                        <textarea class="add-role-impressions-input add-role-impressions-impression" v-model="roleImpression.impression" placeholder="どうだった？"></textarea>  
                      </div>
                      <div class="add-roles-impressions-cell add-role-impressions-body-cell add-role-impressions-cell-photo">
                        <label :for="'add_role_impressions_photo_' + index" class="add-role-impressions-input add-role-impressions-photo-button">選択</label>
                        <input type="file" :id="'add_role_impressions_photo_' + index" class="add-role-impressions-photo" @change="previewFileRoleImpression(index, $event)">
                        <div class="add-role-impressions-photo-area">
                          <!-- 写真 -->
                          <div v-if="roleImpression.photos[0]">
                            <div v-if="roleImpression.photos[0].url && roleImpression.photos[0].photo === 1">
                              <output class="add-role-impressions-photo-output">
                                <button type="button" class="add-role-impressions-photo-resetbutton" @click="deletePhotoRoleImpression(index)"><i class="fa-solid fa-xmark"></i></button>
                                <img :src="roleImpression.photos[0].url" :alt="roleImpression.photos[0].role" style="max-height: 12em">
                              </output>
                            </div>
                            <div v-else-if="roleImpression.photos[0].photo">
                              <output v-if="roleImpression.photos[0].preview" class="add-role-impressions-photo-output">
                                <button type="button" class="add-role-impressions-photo-resetbutton" @click="resetPhotoRoleImpression(index)"><i class="fa-solid fa-xmark"></i></button>
                                <img :src="roleImpression.photos[0].preview" alt="" style="max-height: 12em">
                              </output>
                            </div>
                          </div>                          
                        </div>                      

                        <div v-if="errors.photo.roleImpression" class="add-error-message-role-impressions-photo">{{ errors.photo.roleImpression }}</div>
                      </div>
                    </div>
                  </section>
                  
                </div>
                      
              </div>

              <!-- フォームボタン -->
              <div class="add-add-minus-button-area">
                <div ref="detail_minus_button_area_role_impressions_form" class="add-minus-button-area" style="visibility: hidden">
                  <button type="button" class="add-add-button" @click="minusRoleImpressionForm">
                    <div class="add-add-button-icon">
                      <i class="fa-solid fa-minus"></i>
                    </div>
                  </button>
                </div>
                <div ref="detail_add_button_area_role_impressions_form" class="add-add-button-area" style="visibility: hidden">
                  <button type="button" class="add-add-button" @click="plusRoleImpressionForm">
                    <div class="add-add-button-icon">
                      <i class="fa-solid fa-plus"></i>
                    </div>
                  </button>
                </div>
              </div>
            </div>

            <!-- 歴史 -->
            <div class="add-area add-others-area">
              <div class="add-header add-header-others">
                歴史
              </div>

              <div class="add-others-button-block">
                <!-- 表 -->
                <div class="add-others-box">
                  <!-- ヘッダー -->
                  <div class="add-others-headerline">
                    <div class="add-others-cell add-others-header-cell add-others-cell-title">
                      題名
                    </div>
                    <div class="add-others-cell add-others-header-cell add-others-cell-impression">
                      歴史
                    </div>
                  </div>

                  <!-- 中身 -->
                  <div class="add-others-bodyblock">
                    <draggable v-model="editDVD.histories" group="histories" item-key="key" tag="section">
                      <!-- 1セット -->
                      <template #item="{element : history}">
                        <div class="add-others-bodyline">
                          <div class="add-others-cell add-others-body-cell add-others-cell-title">
                            <input type="text" class="add-others-input add-others-title" v-model="history.title">
                          </div>
                          <div class="add-others-cell add-others-body-cell add-others-cell-impression">
                            <textarea class="add-others-input add-others-impression" placeholder="本当は？" v-model="history.history"></textarea>
                          </div>
                        </div>
                      </template>
                    </draggable>
                  </div>
                </div>

                <!-- フォームボタン -->
                <div class="add-add-minus-button-area">
                  <div ref="detail_minus_button_area_histories_form" class="add-minus-button-area" style="visibility: hidden">
                    <button type="button" class="add-add-button" @click="minusHistoryForm">
                      <div class="add-add-button-icon">
                        <i class="fa-solid fa-minus"></i>
                      </div>
                    </button>
                  </div>
                  <div ref="detail_add_button_area_histories_form" class="add-add-button-area">
                    <button type="button" class="add-add-button" @click="plusHistoryForm">
                      <div class="add-add-button-icon">
                        <i class="fa-solid fa-plus"></i>
                      </div>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- 歌 -->
            <div class="add-area add-others-area">
              <div class="add-header add-header-others">
                歌
              </div>

              <div class="add-others-button-block">
                <!-- 表 -->
                <div class="add-others-box">
                  <!-- ヘッダー -->
                  <div class="add-others-headerline">
                    <div class="add-others-cell add-others-header-cell add-others-cell-title">
                      題名
                    </div>
                    <div class="add-others-cell add-others-header-cell add-songs-cell-singer">
                      歌い手
                    </div>
                    <div class="add-others-cell add-others-header-cell add-songs-cell-impression">
                      感想
                    </div>
                  </div>

                  <!-- 中身 -->
                  <div class="add-others-bodyblock">
                    <draggable v-model="editDVD.songs" group="songs" item-key="key" tag="section" @end="endMoveSong">
                      <!-- 1セット -->
                      <template #item="{element : song, index: songIndex}">
                        <div class="add-others-bodyline">
                          <div class="add-others-cell add-others-body-cell add-others-cell-title">
                            <input type="text" class="add-others-input add-others-title" v-model="song.title">
                          </div>

                          <div class="add-others-cell add-others-body-cell add-songs-cell-singer add-singers-body-cell-singer">
                            <div class="add-song-singer-area">
                              <draggable v-model="song.singers" group="songList_singers" item-key="key" tag="section">
                                <template #item="{element : singer, index: singIndex}">
                                  <div class="add-song-singers-area">
                                    <div class="add-song-singer-type-area">
                                      <div class="add-song-singer-type-box">
                                        <label :for="'detail_song_role_' + songIndex + '_' + singIndex">キャスト</label>
                                        <input :id="'detail_song_role_' + songIndex + '_' + singIndex" type="radio" class="add-song-singer-type-radio" value="role" v-model="singer.type">
                                      </div>
                                      <div class="add-song-singer-type-box">
                                        <label :for="'detail_song_group_' + songIndex + '_' + singIndex">分類</label>
                                        <input :id="'detail_song_group_' + songIndex + '_' + singIndex" type="radio" class="add-song-singer-type-radio" value="group" v-model="singer.type">
                                      </div>
                                      <div class="add-song-singer-type-box">
                                        <label :for="'detail_song_input_' + songIndex + '_' + singIndex">入力</label>
                                        <input :id="'detail_song_input_' + songIndex + '_' + singIndex" type="radio" class="add-song-singer-type-radio" value="name" v-model="singer.type">
                                      </div>
                                    </div>

                                    <div class="add-song-singer-select-area">
                                      <select class="add-song-singer-select-input" v-if="singer.type === 'role'" v-model="singer.role_key">
                                        <option value="">選択</option>
                                        <option v-for="role in optionRoles" 
                                          :value="role.key" :key="role.key">
                                          {{ role.role }}
                                        </option>
                                      </select>

                                      <select class="add-song-singer-select-input" v-if="singer.type === 'group'" v-model="singer.group_key">
                                        <option value="">選択</option>
                                        <option v-for="group in optionGroups" 
                                          :value="group.key" :key="group.key">
                                          {{ group.name }}
                                        </option>
                                      </select>

                                      <input type="text" class="add-song-singer-select-input" v-if="singer.type === 'name'" v-model="singer.name">
                                    </div>
                                  </div>
                                </template>
                              </draggable>                            

                              <!-- フォームボタン -->
                              <div class="add-add-minus-button-area add-add-minus-button-area-small">
                                <div :ref="'detail_minus_button_area_singers_form_' + songIndex" class="add-minus-button-area add-minus-button-area-small" style="visibility: hidden">
                                  <button type="button" class="add-add-button add-add-button-small" @click="minusSingerForm(songIndex)">
                                    <div class="add-add-button-icon add-add-button-icon-small">
                                      <i class="fa-solid fa-minus"></i>
                                    </div>
                                  </button>
                                </div>
                                <div :ref="'detail_add_button_area_singers_form_' + songIndex" class="add-add-button-area add-minus-button-area-small">
                                  <button type="button" class="add-add-button add-add-button-small" @click="plusSingerForm(songIndex)">
                                    <div class="add-add-button-icon add-add-button-icon-small">
                                      <i class="fa-solid fa-plus"></i>
                                    </div>
                                  </button>
                                </div>
                              </div>
                            </div>  
                          </div>

                          <div class="add-others-cell add-others-body-cell add-songs-cell-impression">
                            <textarea class="add-others-input add-others-impression" placeholder="どうだった？" v-model="song.impression"></textarea>
                          </div>
                        </div>
                      </template>
                    </draggable>
                  </div>
                </div>

                <!-- フォームボタン -->
                <div class="add-add-minus-button-area">
                  <div ref="detail_minus_button_area_songs_form" class="add-minus-button-area" style="visibility: hidden">
                    <button type="button" class="add-add-button" @click="minusSongForm">
                      <div class="add-add-button-icon">
                        <i class="fa-solid fa-minus"></i>
                      </div>
                    </button>
                  </div>
                  <div ref="detail_add_button_area_songs_form" class="add-add-button-area">
                    <button type="button" class="add-add-button" @click="plusSongForm">
                      <div class="add-add-button-icon">
                        <i class="fa-solid fa-plus"></i>
                      </div>
                    </button>
                  </div>
                </div>
              </div>
            </div>


            <!-- その他 -->
            <div class="add-area add-others-area">
              <div class="add-header add-header-others">
                その他
              </div>

              <div class="add-others-button-block">
                <!-- 表 -->
                <div class="add-others-box">
                  <!-- ヘッダー -->
                  <div class="add-others-headerline">
                    <div class="add-others-cell add-others-header-cell add-others-cell-title">
                      題目
                    </div>
                    <div class="add-others-cell add-others-header-cell add-others-cell-impression">
                      感想
                    </div>
                  </div>

                  <!-- 中身 -->
                  <div class="add-others-bodyblock">
                    <draggable v-model="editDVD.others" group="others" item-key="key" tag="section">
                      <!-- 1セット -->
                      <template #item="{element : other}">
                        <div class="add-others-bodyline">
                          <div class="add-others-cell add-others-body-cell add-others-cell-title">
                            <input type="text" :ref="'detail_others_title_' + index" class="add-others-input add-others-title" v-model="other.title">
                          </div>
                          <div class="add-others-cell add-others-body-cell add-others-cell-impression">
                            <textarea :ref="'detail_others_impression_' + index" class="add-others-input add-others-impression" placeholder="どうだった？" v-model="other.impression"></textarea>
                          </div>
                        </div>
                      </template>
                    </draggable>
                  </div>
                </div>

                <!-- フォームボタン -->
                <div class="add-add-minus-button-area">
                  <div ref="detail_minus_button_area_others_form" class="add-minus-button-area" style="visibility: hidden">
                    <button type="button" class="add-add-button" @click="minusOtherForm">
                      <div class="add-add-button-icon">
                        <i class="fa-solid fa-minus"></i>
                      </div>
                    </button>
                  </div>
                  <div ref="detail_add_button_area_others_form" class="add-add-button-area">
                    <button type="button" class="add-add-button" @click="plusOtherForm">
                      <div class="add-add-button-icon">
                        <i class="fa-solid fa-plus"></i>
                      </div>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- 写真 -->
            <div class="add-photo-area">
              <div class="add-header">
                写真
              </div>

              <label for="add_photo" class="add-photo-button">選択</label>
              <input type="file" id="add_photo" class="add-photo" @change="previewFile">
              <div class="add-photo-preview-area">
                <!-- 写真 -->
                <div v-if="editDVD.photos[0]">
                  <div v-if="editDVD.photos[0].url && editDVD.photos[0].photo === 1">
                    <output class="add-role-impressions-photo-output">
                      <button type="button" class="add-photo-resetbutton" @click="deletePhoto"><i class="fa-solid fa-xmark"></i></button>
                      <img :src="editDVD.photos[0].url" :alt="editDVD.photos[0].title" class="add-photo-preview">
                    </output>
                  </div>
                  <div v-else-if="editDVD.photos[0].photo">
                    <output v-if="editDVD.photos[0].preview" class="add-role-impressions-photo-output">
                      <button type="button" class="add-photo-resetbutton" @click="resetPhoto"><i class="fa-solid fa-xmark"></i></button>
                      <img :src="editDVD.photos[0].preview" alt="" class="add-photo-preview">
                    </output>
                  </div>
                </div>
                
              </div>                      

              <div v-if="errors.photo.pres" class="add-error-message-photo">{{ errors.photo.pres }}</div>
            </div>      

          </div>

          <div class="add-block-2">
            <div class="add-special-area">
              <div class="add-special-area">
                <label for="detail_edit_format_DVD" class="add-special-header add-official-header">
                  DVD
                </label>
                <input type="radio" id="detail_edit_format_DVD" v-model="editDVD.format" value=1 class="add-special-input add-special" checked>
              </div>

              <div class="add-special-area">
                <label for="detail_edit_format_Blu" class="add-special-header add-official-header">
                  Blu-ray
                </label>
                <input type="radio" id="detail_edit_format_Blu" v-model="editDVD.format" value=2 class="add-special-input add-special">
              </div>
            </div>
            <div class="add-special-area">
              <label for="detail_edit_official" class="add-special-header add-official-header">
                公式
              </label>
              <input type="checkbox" id="detail_edit_official" v-model="editDVD.official" class="add-special-input add-special" checked>
            </div>

            <div class="add-special-area">
              <label for="detail_edit_special" class="add-special-header">
                特典
              </label>
              <input type="checkbox" id="detail_edit_special" v-model="editDVD.special" class="add-special-input add-special">
            </div>

            <div class="add-special-area">
              <div class="add-special-header add-url-header">
                公式
              </div>
              <div class="add-url-DVD-movie-area">
                <div class="add-url-DVD-movie-block add-url-DVD-area">
                  <div class="add-url-DVD-movie-header add-url-DVD-header">
                    イーオシ
                  </div>
                  <input type="text" v-model="editDVD.url_DVD" class="add-special-input add-special-input-text add-url-DVD">
                </div>

                <div class="add-url-DVD-movie-block add-url-movie-area">
                  <div class="add-url-DVD-movie-header add-url-movie-header">
                    ゲキ×シネ
                  </div>
                  <input type="text" v-model="editDVD.url_movie" class="add-special-input add-special-input-text add-url-movie">
                </div>

                <div class="add-url-DVD-movie-block add-url-movie-area">
                  <div class="add-url-DVD-movie-header add-url-movie-header">
                    映像
                  </div>
                  <input type="text" v-model="editDVD.url_youtube" class="add-special-input add-special-input-text add-url-movie">
                </div>
              </div>
            </div>

            <div class="add-special-area">
              <div class="add-special-header add-category-header">
                カテゴリー
              </div>
              <select class="add-special-input add-special-input-text add-category" v-model="editDVD.category">
                <option v-for="category in optionCategories" 
                  :value="category.value">
                  {{ category.title }}
                </option>
              </select>
            </div>
          </div>
        </div>
        
        <!-- ボタン -->
        <div class="add-button-area">
          <button type="submit" class="add-button add-submit-button">
            <div class="add-button-icon">
              編集
            </div>
          </button>
        </div>
      </form>
    </div>
    <messageDialog :postMessage_Message="dialog_message" v-show="showContent_message" @close="closeModal_message"/>
    <confirmDialog :postMessage_Confirm="dialog_confirm" v-show="showContent_confirm" @Cancel="closeModal_confirm_Cancel" @OK="closeModal_confirm_OK"/>
    <photoDialog :postURL="dialog_url" v-show="showContent_photo" @close="closeModal_photo"/>
  </div>
</template>

<script>
import { OK, UNPROCESSABLE_ENTITY } from '../util'
import messageDialog from '../components/Message_Dialog.vue'
import confirmDialog from '../components/Confirm_Dialog.vue'
import photoDialog from '../components/Photo_Dialog.vue'

import draggable from 'vuedraggable'

// ふりがな
import * as AutoKana from 'vanilla-autokana';

let autokana;

export default {
  props: {
    propDVD: {
      type: String,
      required: true
    }
  },
  // このページの上で表示するコンポーネント
  components: {
    messageDialog,
    confirmDialog,
    photoDialog,
    draggable
  },
  // データ
  data() {
    return {
      // 表示するDVDのデータ
      DVD: {},
      // 元データ
      originalDVD: {},
      // 貸出可否
      rentFlag: 0,      
      
      // 編集用元データ
      originalEditDVD: {},
      // 編集するデータ
      editDVD: {
        title: null,
        kana: null,
        duration_from: '2023-01-01',
        duration_to: '2023-04-01',
        locations : [],
        impression: '',
        story: '',
        author: '',
        costumers: [],
        lyricist: '',
        choreo: '',
        director: '',
        playerList : [],
        groups : [],
        roleImpressionList: [],
        histories: [],
        songs: [],
        others: [],
        photos: [],
        format: 1,
        official: true,
        special: false,
        url_DVD: '',
        url_movie: '',
        url_youtube: '',
        category: 1
      },
      playersAll: null,
      playerFlag: false,
      optionPlayers : [], // 役者
      optionGroups : [], // 分類名
      optionRoles : [], // 役名
      // エラー
      errors: {
        photo: {
          roleImpression: null,
          pres: null
        },
        error: null,
      },

      // message
      showContent_message: false,
      dialog_message: '',
      // confirm
      showContent_confirm: false,
      dialog_confirm: '',
      // photo
      showContent_photo: false,
      dialog_url: '',

      // タブ
      tab: 1,

      // 都道府県
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
        { title:'沖縄県', value :47 }],
      members : ['古田新太', '橋本じゅん', '高田聖子', '粟根まこと', '右近健一', '逆木圭一郎', '河野まさと', '村木よし子', 'インディ高橋', '山本カナコ', '礒野慎吾', '吉田メタル', '中谷さとみ', '保坂エマ', 'こぐれ修', '枯暮修', '竹田団吾', '羽野アキ', '羽野晶紀', '杉本恵美', 'タイソン大屋'], // 劇団員
      
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
    propDVD: {
      async handler(propDVD) {
        if(this.propDVD){
          await this.fetchDVD();
        }        
      },
      immediate: true,
    }
  },
  methods: {
    // ランダム文字列作成
    getUniqueStr(){
      const strong = 1000;
      return new Date().getTime().toString(16)  + Math.floor(strong*Math.random()).toString(16)
    },

    // DVDの詳細を取得
    async fetchDVD () {
      const response = await axios.get('/api/DVD/'+ this.propDVD);

      if (response.status !== 200) {
        this.$store.commit('error/setCode', response.status);
        return false;
      }

      this.DVD = response.data;
      let count = 0;
      this.DVD.roles.forEach(role => {
        if(role.impression){
          if(!this.DVD.roleImpressionList) {
            this.DVD.roleImpressionList = [];
          }
          this.DVD.roleImpressionList[count] = new Object();
          const newRoleImpression = {role_id: role.id, order: role.order, role: role.role, player: role.player, impression: role.impression, photos: role.role_photos};
          this.DVD.roleImpressionList[count] = newRoleImpression;
          count++;
        }
      });
      if(!this.DVD.roleImpressionList) {
        this.DVD.roleImpressionList = [];
      }
      this.DVD.locations.sort((a, b) => a.order - b.order );
      this.DVD.costumers.sort((a, b) => a.order - b.order );
      this.DVD.roles.sort((a, b) => a.order - b.order );
      this.DVD.roleImpressionList.sort((a, b) => a.order - b.order);
      this.DVD.role_groups.sort((a, b) => a.order - b.order);
      this.DVD.songs.sort((a, b) => a.order - b.order);
      this.DVD.songs.forEach((song) => {
        song.singers.sort((a, b) => a.order - b.order);
      });
      this.DVD.others.sort((a, b) => a.order - b.order);

      this.originalDVD = JSON.parse(JSON.stringify(this.DVD));
      if(this.originalDVD.rents) {
        this.rentFlag = this.DVD.rents.find(rent => rent.flag == 1);
      }

      let m = 0;
      let k = 0;
      this.editDVD.title = this.originalDVD.title;
      this.editDVD.kana = this.originalDVD.kana;
      this.editDVD.duration_from = this.originalDVD.duration_from ? this.originalDVD.duration_from : null;
      this.editDVD.duration_to = this.originalDVD.duration_to ? this.originalDVD.duration_to: null;
      this.editDVD.locations = this.originalDVD.locations ? this.originalDVD.locations : null;
      this.editDVD.locations.sort((a, b) => a.order - b.order);

      this.editDVD.impression = this.originalDVD.impression ? this.originalDVD.impression : '';
      this.editDVD.story = this.originalDVD.story ? this.originalDVD.story : '';
      this.editDVD.author = this.originalDVD.author ? this.originalDVD.author : '';
      this.editDVD.director = this.originalDVD.director ? this.originalDVD.director : '';
      this.editDVD.costumers = this.originalDVD.costumers ? this.originalDVD.costumers : null;
      this.editDVD.costumers.sort((a, b) => a.order - b.order);
      this.editDVD.lyricist = this.originalDVD.lyricist ? this.originalDVD.lyricist : '';
      this.editDVD.choreo = this.originalDVD.choreo ? this.originalDVD.choreo : '';

      this.originalDVD.roles.forEach((role, index) => {
        const key = this.getUniqueStr();
        this.editDVD.playerList[index] = new Object();
        this.editDVD.playerList[index].id = role.id;
        this.editDVD.playerList[index].key = key;
        this.editDVD.playerList[index].order = role.order;
        this.editDVD.playerList[index].group_id = role.role_group_id ? role.role_group_id : null;
        this.editDVD.playerList[index].role = role.role ? role.role : null;
        this.editDVD.playerList[index].player = role.player ? role.player : null;
        this.editDVD.playerList[index].member = role.member ? true : false;
        if(role.role) {
          this.optionRoles[m] = new Object();
          this.optionRoles[m].id = role.id;
          this.optionRoles[m].order = role.order;
          this.optionRoles[m].key = key;
          this.optionRoles[m].role = role.role;
          m++;
        }        
        if(role.impression) {
          this.editDVD.roleImpressionList[k] = new Object();
          this.editDVD.roleImpressionList[k].role_id = role.id;
          this.editDVD.roleImpressionList[k].order = role.order;
          this.editDVD.roleImpressionList[k].role_key = key;
          this.editDVD.roleImpressionList[k].impression = role.impression;
          this.editDVD.roleImpressionList[k].photos = []
          if(role.role_photos.length) {
            this.editDVD.roleImpressionList[k].photos[0] = new Object();
            this.editDVD.roleImpressionList[k].photos[0].id = role.role_photos[0].id;
            this.editDVD.roleImpressionList[k].photos[0].public_id = role.role_photos[0].public_id;
            this.editDVD.roleImpressionList[k].photos[0].url = role.role_photos[0].url;
            this.editDVD.roleImpressionList[k].photos[0].photo = 1; // 写真が登録されている（可能性：1のまま、0に変更（この時public_idは存在する）、写真バイナリ代入（この時public_idは存在する））
            this.editDVD.roleImpressionList[k].photos[0].preview = null;
          } else {
            this.editDVD.roleImpressionList[k].photos[0] = new Object();
            this.editDVD.roleImpressionList[k].photos[0].photo = 0; // 写真が登録されていない（可能性：0のまま（この時pubic_idは存在しない）、写真バイナリ代入（この時public_idは存在しない））
          }
          k++;
        }
      });
      this.editDVD.playerList.sort((a, b) => a.order - b.order);
      this.optionRoles.sort((a, b) => a.order - b.order);
      this.editDVD.roleImpressionList.sort((a, b) => a.order = b.order);

      this.originalDVD.role_groups.forEach((group, index) => {
        const key = this.getUniqueStr();
        this.editDVD.groups[index] = new Object();
        this.editDVD.groups[index].id = group.id;
        this.editDVD.groups[index].order = group.order;
        this.editDVD.groups[index].name = group.name;
        this.editDVD.groups[index].key = key;
        this.optionGroups[index] = new Object();
        this.optionGroups[index].id = group.id;
        this.optionGroups[index].order = group.order;
        this.optionGroups[index].name = group.name;
        this.optionGroups[index].key = key;
        this.editDVD.playerList.filter(player => {
          if(player.group_id === group.id) {
            player.group_key = key;
          } else if(!player.group_key) {
            player.group_key = '';
          }
        });
      });
      this.editDVD.groups.sort((a, b) => a.order - b.order);
      this.optionGroups.sort((a, b) => a.order - b.order);

      this.editDVD.histories = this.originalDVD.histories ? this.originalDVD.histories : null;
      this.editDVD.histories.sort((a, b) => a.order - b.order);
      
      this.originalDVD.songs.forEach((song, index) => {
        const key = this.getUniqueStr();
        this.editDVD.songs[index] = new Object();
        this.editDVD.songs[index].id = song.id;
        this.editDVD.songs[index].order = song.order;
        this.editDVD.songs[index].title = song.title;
        this.editDVD.songs[index].impression = song.impression ? song.impression : null;
        this.editDVD.songs[index].singers = new Array();

        song.singers.forEach((singer, index2) => {
          this.editDVD.songs[index].singers[index2] = new Object();
          this.editDVD.songs[index].singers[index2].id = singer.id;
          this.editDVD.songs[index].singers[index2].order = singer.order;
          this.editDVD.songs[index].singers[index2].role_id = singer.role_id ? singer.role_id : null;
          this.editDVD.songs[index].singers[index2].role_key = this.editDVD.playerList.find(player => player.id === singer.role_id) ? this.editDVD.playerList.find(player => player.id === singer.role_id).key : '';
          this.editDVD.songs[index].singers[index2].group_id = singer.role_group_id ? singer.role_group_id : null;
          this.editDVD.songs[index].singers[index2].group_key = this.editDVD.groups.find(group => group.id === singer.role_group_id) ? this.editDVD.groups.find(group => group.id === singer.role_group_id).key : '';
          this.editDVD.songs[index].singers[index2].name = singer.name ? singer.name : null;
          this.editDVD.songs[index].singers[index2].type = singer.role_id ? 'role' : singer.role_group_id ? 'group' : 'name';
        });
      });
      this.editDVD.songs.sort((a, b) => a.order - b.order);
      this.editDVD.songs.forEach((song) => {
        song.singers.sort((a, b) => a.order - b.order);
      });

      this.editDVD.others = this.originalDVD.others ? this.originalDVD.others : null;

      if(this.originalDVD.photos.length) {
        this.editDVD.photos[0] = new Object();
        this.editDVD.photos[0].public_id = this.originalDVD.photos[0].public_id;
        this.editDVD.photos[0].url = this.originalDVD.photos[0].url;
        this.editDVD.photos[0].id = this.originalDVD.photos[0].id;
        this.editDVD.photos[0].photo = 1;
      } else {
        this.editDVD.photos[0] = new Object();
        this.editDVD.photos[0].photo = 0;
      }

      this.editDVD.format = this.originalDVD.format;
      this.editDVD.official = this.originalDVD.official ? true : false;
      this.editDVD.special = this.originalDVD.special ? true : false;
      this.editDVD.url_DVD = this.originalDVD.url_DVD ? this.originalDVD.url_DVD : '';
      this.editDVD.url_movie = this.originalDVD.url_movie ? this.originalDVD.url_movie : '';
      this.editDVD.url_youtube = this.originalDVD.url_youtube ? this.originalDVD.url_youtube : '';
      this.editDVD.category = this.originalDVD.category;

      this.originalEditDVD = JSON.parse(JSON.stringify(this.editDVD));

      this.showButton();
    },

    // 描写後
    showButton() {
      this.$nextTick(() => {
        const screenWidth = document.documentElement.clientWidth;
        let mainRem = 0;
        if(screenWidth <= 767) {
          mainRem = this.convertRem2Px(2) * 2;
        } else {
          mainRem = this.convertRem2Px(4) * 2;
        }

        // 役感想
        if(this.$refs.detail_show_role_impression_headers) {
          this.$refs.detail_show_role_impression_headers.forEach(header => {
            if(header.clientWidth + mainRem >= screenWidth) {
              header.classList.add('detail-show-role-impression-detail-header');
              header.children[0].classList.add('detail-show-role-impression-detail-player-brackets');
            }
          });
        }        

        // 歌タイトル
        if(this.$refs.detail_song_titles) {
          this.$refs.detail_song_titles.forEach(song => {
            if(song.clientWidth + mainRem >= screenWidth) {
              song.classList.add('detail-show-singer-title-area');
              song.children[1].classList.add('detail-show-singer-column-1');
              song.children[1].children[1].classList.add('detail-show-singer-column-2');
              if(song.children[1].children[1].clientWidth + mainRem >= screenWidth) {
                song.children[1].children[1].children[0].classList.add('detail-show-singer-column-3');
              }
            }
          });
        }

        if(!this.editDVD.locations.length) {
          this.plusLocationForm();
        }

        if(!this.editDVD.costumers.length) {
          this.plusCostumerForm();
        }

        if(!this.editDVD.playerList.length) {
          this.plusPlayerForm();
        } else {
          if(this.editDVD.playerList.length < 50) {
            this.$refs.detail_add_button_area_players_form.style.visibility = 'visible';
          } else {
            this.$refs.detail_add_button_area_players_form.style.visibility = 'hidden';
          }
          
          if(this.editDVD.playerList.length > 1) {
            this.$refs.detail_minus_button_area_players_form.style.visibility = 'visible';
          } else {
            this.$refs.detail_minus_button_area_players_form.style.visibility = 'hidden';
          }
        }
        if(!this.editDVD.roleImpressionList.length) {
          this.plusRoleImpressionForm();
        } else if(this.editDVD.roleImpressionList.length <= this.editDVD.playerList.length) {
          if(this.editDVD.roleImpressionList.length < 50 && this.editDVD.roleImpressionList.length < this.editDVD.playerList.length) {
            this.$refs.detail_add_button_area_role_impressions_form.style.visibility = 'visible';
          } else {
            this.$refs.detail_add_button_area_role_impressions_form.style.visibility = 'hidden';
          }

          if(this.editDVD.roleImpressionList.length > 1) {
            this.$refs.detail_minus_button_area_role_impressions_form.style.visibility = 'visible';
          } else {
            this.$refs.detail_minus_button_area_role_impressions_form.style.visibility = 'hidden';
          }
        }
        
        if(!this.editDVD.groups.length) {
          this.plusGroupForm();
        } else if(this.editDVD.groups.length <= this.editDVD.playerList.length) {
          if(this.editDVD.groups.length < 5 && this.editDVD.groups.length < this.editDVD.playerList.length) {
            this.$refs.detail_add_button_area_groups_form.style.visibility = 'visible';
          } else {
            this.$refs.detail_add_button_area_groups_form.style.visibility = 'hidden';
          }

          if(this.editDVD.groups.length > 1) {
            this.$refs.detail_minus_button_area_groups_form.style.visibility = 'visible';
          } else {
            this.$refs.detail_minus_button_area_groups_form.style.visibility = 'hidden';
          }
        }

        if(!this.editDVD.histories.length) {
          this.plusHistoryForm();
        } else {
          if(this.editDVD.histories.length < 10) {
            this.$refs.detail_add_button_area_histories_form.style.visibility = 'visible';
          } else {
            this.$refs.detail_add_button_area_histories_form.style.visibility = 'hidden';
          }
          
          if(this.editDVD.histories.length > 1) {
            this.$refs.detail_minus_button_area_histories_form.style.visibility = 'visible';
          } else {
            this.$refs.detail_minus_button_area_histories_form.style.visibility = 'hidden';
          }
        }
        
        if(!this.editDVD.songs.length) {
          this.plusSongForm();
        } else {
          if(this.editDVD.songs.length < 10) {
            this.$refs.detail_add_button_area_songs_form.style.visibility = 'visible';
          } else {
            this.$refs.detail_add_button_area_songs_form.style.visibility = 'hidden';
          }
          
          if(this.editDVD.songs.length > 1) {
            this.$refs.detail_minus_button_area_songs_form.style.visibility = 'visible';
          } else {
            this.$refs.detail_minus_button_area_songs_form.style.visibility = 'hidden';
          }
        }
        
        if(!this.editDVD.others.length) {
          this.plusOtherForm();
        } else {
          if(this.editDVD.others.length < 10) {
            this.$refs.detail_add_button_area_others_form.style.visibility = 'visible';
          } else {
            this.$refs.detail_add_button_area_others_form.style.visibility = 'hidden';
          }
          
          if(this.editDVD.others.length > 1) {
            this.$refs.detail_minus_button_area_others_form.style.visibility = 'visible';
          } else {
            this.$refs.detail_minus_button_area_others_form.style.visibility = 'hidden';
          }
        }

        // ふりがなのinput要素のidは省略可能
        autokana = AutoKana.bind('#detail_title');

        // 歌フォーム描写後
        this.$nextTick(() => {
          this.editDVD.songs.forEach((song, index) => {
            const addButton = 'detail_add_button_area_singers_form_' + index;
            const minusButton = 'detail_minus_button_area_singers_form_' + index;
            if(song.singers.length < 10) {
              this.$refs[addButton].style.visibility = 'visible';
            } else {
              this.$refs[addButton].style.visibility = 'hidden';
            }
            
            if(song.singers.length > 1) {
              this.$refs[minusButton].style.visibility = 'visible';
            } else {
              this.$refs[minusButton].style.visibility = 'hidden';
            }
          });
        });
      });      
    },

    // remからpx
    convertRem2Px(rem) {
      const fontSize = getComputedStyle(document.documentElement).fontSize;
      return rem * parseFloat(fontSize);
    },

    // 出演者纏めて
    getAllPlayers() {
      let keyupPlayers = this.playersAll;
      keyupPlayers = keyupPlayers.replace(' / ', '　');
      keyupPlayers = keyupPlayers.replace(' / ', '　');
      keyupPlayers = keyupPlayers.replace(' / ', '　');
      let tempPlayers = keyupPlayers.split(/,|、|　|  | /);
      this.optionPlayers = tempPlayers.filter(Boolean);
      this.inputPlayersAll();
    },
    inputPlayersAll() {
      this.optionPlayers.forEach((player, index) => {
        let member = false;
        if(this.members.includes(player)) {
          member = true;
        };

        if(index < this.editDVD.playerList.length){
          this.editDVD.playerList[index].player = player;
          this.editDVD.playerList[index].member = member;
        } else {
          this.editDVD.playerList.push({
            id: null, group_key: null, group_id: null, role: null, player: player, member: member
          });
        }

        this.playerFlag = true;
        this.plusPlayerForm();
      })
    },

    // 入力された分類名をプルダウンメニューに追加
    getGroup: function(key) {
      const optionGroup = this.optionGroups.find(group => group.key === key);
      const group = this.editDVD.groups.find(group => group.key === key);

      if(!optionGroup && group.name) {
        const newGroupOption = {id: null, key: key, order: group.order, name: group.name};
        this.optionGroups.push(newGroupOption);
      } else {
        optionGroup.name = group.name;
      }
    },

    // 入力された役名をプルダウンメニューに追加
    getRole: function(key) {
      const optionRole = this.optionRoles.find(role => role.key === key);
      const player = this.editDVD.playerList.find(role => role.key === key);

      if(!optionRole && player.role) {
        const newRoleOption = {id: null, key: key, order:player.order, role:player.role};
        this.optionRoles.push(newRoleOption);
      } else {
        optionRole.role = player.role;
      }
    },

    // 写真プレビュー
    previewFileRoleImpression: function(index, event) {
      this.errors.photo.roleImpression = null;
      // 何も選択されていなかったら処理中断
      if (event.target.files.length === 0) {
        this.resetPhotoRoleImpression(index);
        return false;
      }

      // ファイルが画像ではなかったら処理中断
      if (!event.target.files[0].type.match('image.*')) {
        this.resetPhotoRoleImpression(index);
        this.errors.photo.roleImpression = '写真データを選択してください';
        return false;
      }

      // FileReaderクラスのインスタンスを取得
      const reader = new FileReader();

      // ファイルを読み込み終わったタイミングで実行する処理
      reader.onload = e => {
        // previewに読み込み結果（データURL）を代入する
        // previewに値が入ると<output>につけたv-ifがtrueと判定される
        // また<output>内部の<img>のsrc属性はpreviewの値を参照しているので
        // 結果として画像が表示される
        this.editDVD.roleImpressionList[index].photos[0].preview = e.target.result;
      }

      // ファイルを読み込む
      // 読み込まれたファイルはデータURL形式で受け取れる（上記onload参照）
      reader.readAsDataURL(event.target.files[0]);
  
      if(this.editDVD.roleImpressionList[index].photos[0].photo === 1) {
        this.deletePhotoRoleImpression(index);
      }
      this.editDVD.roleImpressionList[index].photos[0].photo = event.target.files[0];
    },

    // 画像をクリアするメソッド
    resetPhotoRoleImpression: function(index) {
      this.editDVD.roleImpressionList[index].photos[0].preview = null;
      this.editDVD.roleImpressionList[index].photos[0].photo = '';
      document.getElementById('add_role_impressions_photo_' + index).value = null;
    },

    // 写真を見せない
    deletePhotoRoleImpression : function (index) {
      this.editDVD.roleImpressionList[index].photos[0].photo = 0;
      this.editDVD.roleImpressionList[index].photos[0].url = '';
    },

    // 写真プレビュー
    previewFile(event) {
      this.errors.photo.pres = null;
      // 何も選択されていなかったら処理中断
      if (event.target.files.length === 0) {
        this.resetPhoto();
        return false;
      }

      // ファイルが画像ではなかったら処理中断
      if (!event.target.files[0].type.match('image.*')) {
        this.resetPhoto();
        this.errors.photo.pres = '写真データを選択してください';
        return false;
      }

      // FileReaderクラスのインスタンスを取得
      const reader = new FileReader();

      // ファイルを読み込み終わったタイミングで実行する処理
      reader.onload = e => {
        // previewに読み込み結果（データURL）を代入する
        // previewに値が入ると<output>につけたv-ifがtrueと判定される
        // また<output>内部の<img>のsrc属性はpreviewの値を参照しているので
        // 結果として画像が表示される
        this.editDVD.photos[0].preview = e.target.result;
      }

      // ファイルを読み込む
      // 読み込まれたファイルはデータURL形式で受け取れる（上記onload参照）
      reader.readAsDataURL(event.target.files[0]);
      if(this.editDVD.photos[0].photo === 1) {
        this.deletePhoto();
      }
      this.editDVD.photos[0].photo = event.target.files[0];
    },

    // 写真を見せない
    deletePhoto(){
      this.editDVD.photos[0].photo = 0;
      this.editDVD.photos[0].url = '';
    },
    // 画像をクリアするメソッド
    resetPhoto() {
      this.editDVD.photos[0].preview = null;
      this.editDVD.photos[0].photo = 0;
      document.getElementById('add_photo').value = null;
    },

    // 編集確認
    confirmEditData() {
      let flag = 0; // 0なら変更なし、1は変更あり（0なら通す）
      let patternNumber = /^([0-9]\d*|0)$/; // 0~9の数字かどうか
      let patternAlf = /^([A-Z]\d*)$/; // A~Zのアルファベットかどうか*いる
      let patternKanaHira = /^[ぁ-んァ-ンヴーｧ-ﾝﾞﾟ\-]+$/u;
      let kanas;
      let kana = '';

      if(!this.editDVD.title || !this.editDVD.kana) {
        return false;
      }      

      if(this.originalEditDVD.title !== this.editDVD.title || this.originalEditDVD.duration_from !== this.editDVD.duration_from || this.originalEditDVD.duration_to !== this.editDVD.duration_to
         || this.originalEditDVD.story !== this.editDVD.story || this.originalEditDVD.impression !== this.editDVD.impression || this.originalEditDVD.author !== this.editDVD.author || this.originalEditDVD.lyricist !== this.editDVD.lyricist || this.originalEditDVD.choreo !== this.editDVD.choreo || this.originalEditDVD.director !== this.editDVD.director
         || this.originalEditDVD.format !== this.editDVD.format || this.originalEditDVD.official !== this.originalEditDVD.official
         || this.originalEditDVD.special !== this.originalEditDVD.special || this.originalEditDVD.url_DVD !== this.editDVD.url_DVD || this.originalEditDVD.url_movie !== this.editDVD.url_movie || this.originalEditDVD.url_youtube !== this.editDVD.url_youtube || this.originalEditDVD.category !== this.editDVD.category
      ) {
        flag = 1;
      }

      this.editDVD.locations = this.editDVD.locations.filter(location => location.prefecture ? location : null);
      for(let i = 0; i < this.editDVD.locations.length; i++) {
        this.editDVD.locations[i].order = i + 1;
      }
      if(!flag && this.originalEditDVD.locations.length === this.editDVD.locations.length) {
        this.originalEditDVD.locations.forEach((location, index)  => {
          if(location.id !== this.editDVD.locations[index].id || location.order !== this.editDVD.locations[index].order || location.prefecture !== this.editDVD.locations[index].prefecture || location.theater !== this.editDVD.locations[index].theater) {
            flag = 1;
          }
        });
      } else {
        flag = 1;
      }
      if(!this.editDVD.locations.length) {
        this.plusLocationForm();
      }

      this.editDVD.costumers = this.editDVD.costumers.filter(costumer => costumer.name ? costumer : null);
      for(let i = 0; i < this.editDVD.costumers.length; i++) {
        this.editDVD.costumers[i].order = i + 1;
      }
      if(!flag && this.originalEditDVD.costumers.length === this.editDVD.costumers.length) {
        this.originalEditDVD.costumers.forEach((costumer, index)  => {
          if(costumer.id !== this.editDVD.costumers[index].id || costumer.order !== this.editDVD.costumers[index].order || costumer.name !== this.editDVD.costumers[index].name ) {
            flag = 1;
          }
        });
      } else {
        flag = 1;
      }
      if(!this.editDVD.costumers.length) {
        this.plusCostumerForm();
      }
      
      this.editDVD.groups = this.editDVD.groups.filter(group => group.name ? group : null);
      this.optionGroups = this.optionGroups.filter(group => group.name ? group : null);
      for(let i = 0; i < this.editDVD.groups.length; i++) {
        this.editDVD.groups[i].order = i + 1;
      }
      if(!flag && this.originalEditDVD.groups.length === this.editDVD.groups.length) {
        this.originalEditDVD.groups.forEach((group, index)  => {
          if(group.id !== this.editDVD.groups[index].id || group.order !== this.editDVD.groups[index].order || group.name !== this.editDVD.groups[index].name ) {
            flag = 1;
          }
        });
      } else {
        flag = 1;
      }
      if(!this.editDVD.groups.length) {
        this.plusGroupForm();
      }

      this.editDVD.playerList = this.editDVD.playerList.filter(player => player.player ? player : null);
      this.optionRoles = this.optionRoles.filter(role => role.role ? role : null);
      for(let i = 0; i < this.editDVD.playerList.length; i++) {
        this.editDVD.playerList[i].order = i + 1;
      }
      if(!flag && this.originalEditDVD.playerList.length === this.editDVD.playerList.length) {
        this.originalEditDVD.playerList.forEach((player,index) => {
          if(player.group_key !== this.editDVD.playerList[index].group_key || player.group_id !== this.editDVD.playerList[index].group_id || player.id !== this.editDVD.playerList[index].id
            || player.order !== this.editDVD.playerList[index].order || player.member !== this.editDVD.playerList[index].member || player.player !== this.editDVD.playerList[index].player || player.role !== this.editDVD.playerList[index].role
          ){
            flag = 1;
          }
        });
      } else {
        flag = 1;
      }
      if(!this.editDVD.playerList.length) {
        this.plusPlayerForm();
      }

      this.editDVD.roleImpressionList = this.editDVD.roleImpressionList.filter(roleImpression => roleImpression.impression ? roleImpression : null);
      for(let i = 0; i < this.editDVD.roleImpressionList.length; i++) {
        this.editDVD.roleImpressionList[i].order = i + 1;
      }
      if(!flag && this.originalEditDVD.roleImpressionList.length === this.editDVD.roleImpressionList.length) {
        this.originalEditDVD.roleImpressionList.forEach((role,index) => {
          if(role.impression !== this.editDVD.roleImpressionList[index].impression || role.role_key !== this.editDVD.roleImpressionList[index].role_key || role.role_id !== this.editDVD.roleImpressionList[index].role_id){
            flag = 1;
          } else {
            role.photos.forEach((photo, index2) => {
              if(photo.photo !== this.editDVD.roleImpressionList[index].photos[index2].photo) {
                flag = 1;
              }
            });
          }
        });
      } else {
        flag = 1;
      }
      if(!this.editDVD.roleImpressionList.length) {
        this.plusRoleImpressionForm();
      }

      this.editDVD.photos = this.editDVD.photos.filter(photo => photo.photo || photo.photo === 0 ? photo : null);
      if(!this.editDVD.photos.length) {
        this.editDVD.photos[0].photo = 0;
      }
      if(!flag && this.originalEditDVD.photos.length === this.editDVD.photos.length) {
        this.originalEditDVD.photos.forEach((photo, index) => {
          if(photo.photo !== this.editDVD.photos[index].photo) {
            flag = 1;
          }
        });
      } else {
        flag = 1;
      }

      this.editDVD.histories = this.editDVD.histories.filter(history => history.title || history.history ? history : null);
      for(let i = 0; i < this.editDVD.histories.length; i++) {
        this.editDVD.histories[i].order = i + 1;
      }
      if(!flag && this.originalEditDVD.histories.length === this.editDVD.histories.length) {
        this.originalEditDVD.histories.forEach((other, index) => {
          if(history.id !== this.editDVD.histories[index].id || history.order !== this.editDVD.histories[index].order || history.title !== this.editDVD.histories[index].title || history.history !== this.editDVD.histories[index].history ) {
            flag = 1;
          }
        });
      } else {
        flag = 1;
      }
      if(!this.editDVD.histories.length) {
        this.plusHistoryForm();
      }

      this.editDVD.songs = this.editDVD.songs.filter(song => song.title ? song : null);
      for(let i = 0; i < this.editDVD.songs.length; i++) {
        this.editDVD.songs[i].order = i + 1;
        this.editDVD.songs[i].singers = this.editDVD.songs[i].singers.filter(singer => singer.role_key || singer.group_key  || singer.name ? 1 : null);
        for(let k = 0; k < this.editDVD.songs[i].singers.length; k++) {
          this.editDVD.songs[i].singers[k].order = k + 1;
        }
      }
      if(!flag && this.originalEditDVD.songs.length === this.editDVD.songs.length) {
        this.originalEditDVD.songs.forEach((song, index) => {
          if(song.id !== this.editDVD.songs[index].id || song.order !== this.editDVD.songs[index].order || song.title !== this.editDVD.songs[index].title || song.impression !== this.editDVD.songs[index].impression) {
            flag = 1;
          } else {
            if(song.singers.length === this.editDVD.songs[index].singers.length) {
              song.singers.forEach((singer, index2) => {
                if(singer.id !== this.editDVD.songs[index].singers[index2].id || singer.order !== this.editDVD.songs[index].singers[index2].order || singer.type !== this.editDVD.songs[index].singers[index2].type) {
                  flag = 1;
                } else if(singer.type === 'role') {
                  if(singer.role_key !== this.editDVD.songs[index].singers[index2].role_key || singer.role_id !== this.editDVD.songs[index].singers[index2].role_id) {
                    flag = 1;
                  }
                } else if(singer.type === 'group') {
                  if(singer.group_key !== this.editDVD.songs[index].singers[index2].group_key || singer.group_id !== this.editDVD.songs[index].singers[index2].group_id) {
                    flag = 1;
                  }
                } else {
                  if(singer.name !== this.editDVD.songs[index].singers[index2].name) {
                    flag = 1;
                  }
                }
              });
            } else {
              flag = 1;
            }            
          }
        });
      } else {
        flag = 1;
      }
      if(!this.editDVD.songs.length) {
        this.plusSongForm();
      }
      this.editDVD.songs.forEach((song, index) => {
        if(!song.singers.length) {
          this.plusSingerForm(index);
        }
      });

      this.editDVD.others = this.editDVD.others.filter(other => other.title || other.impression ? other : null);
      for(let i = 0; i < this.editDVD.others.length; i++) {
        this.editDVD.others[i].order = i + 1;
      }
      if(!flag && this.originalEditDVD.others.length === this.editDVD.others.length) {
        this.originalEditDVD.others.forEach((other, index) => {
          if(other.id !== this.editDVD.others[index].id || other.order !== this.editDVD.others[index].order || other.title !== this.editDVD.others[index].title || other.impression !== this.editDVD.others[index].impression) {
            flag = 1;
          }
        });
      } else {
        flag = 1;
      }
      if(!this.editDVD.others.length) {
        this.plusOtherForm();
      }

      // タイトル（ふりがな）正規表現
      kanas = [...this.editDVD.kana];
      kanas.forEach(a => {
        const number = this.Zenkaku2hankaku_number(a);
        if(patternNumber.test(number)){
          // 数字だった
          kana = kana + number;
        }else{
          // 数字じゃなかった=文字だった
          const alf = this.Zenkaku2hankaku_alf(number);
          if(patternAlf.test(alf.toUpperCase())){
            // アルファベットだった
            kana = kana + alf.toUpperCase();
          }else if(patternKanaHira.test(alf)){
            // アルファベットじゃなかった=ひらがなかカタカナだった
            const str = this.hunkaku2Zenkaku_str(alf);
            kana = kana + this.Hira2Kana(str);
          }else if(alf == "-" || alf == " "){
            kana = kana + alf;
          }
        }
      });

      if(!flag && this.originalEditDVD.kana !== kana) {
        flag = 1;
      }


      if(!flag) {
        this.showContent_message = true;
        this.dialog_message = '元のデータと同じです。編集してください。';
      } else {
        this.showContent_confirm = true;
        this.dialog_confirm = '編集'
      }
    },
    
    // messageモーダルを閉じる
    closeModal_message() {
      this.showContent_message = false;
      this.dialog_message = '';
    },
    // confirmのモーダル非表示_OKの場合
    async closeModal_confirm_OK() {
      this.showContent_confirm = false;
      if(this.dialog_confirm == '編集') {
        await this.editData();
      } else if(this.dialog_confirm == '削除') {
        await this.deleteData();
      }
      this.dialog_confirm = '';
    },
    // confirmのモーダル非表示_Cancelの場合
    closeModal_confirm_Cancel() {
      this.showContent_confirm = false;
      this.dialog_confirm = ''
    },
    // データ送信
    async editData() {
      let patternNumber = /^([0-9]\d*|0)$/; // 0~9の数字かどうか
      let patternAlf = /^([A-Z]\d*)$/; // A~Zのアルファベットかどうか*いる
      let patternKanaHira = /^[ぁ-んァ-ンヴーｧ-ﾝﾞﾟ\-]+$/u;
      const formData = new FormData();
      let kanas;
      let kana = '';
      let count = 0;
      
      if(!this.editDVD.title || !this.editDVD.kana) {
        return false;
      }

      // タイトル（ふりがな）正規表現
      kanas = [...this.editDVD.kana];
      kanas.forEach(a => {
        const number = this.Zenkaku2hankaku_number(a);
        if(patternNumber.test(number)){
          // 数字だった
          kana = kana + number;
        }else{
          // 数字じゃなかった=文字だった
          const alf = this.Zenkaku2hankaku_alf(number);
          if(patternAlf.test(alf.toUpperCase())){
            // アルファベットだった
            kana = kana + alf.toUpperCase();
          }else if(patternKanaHira.test(alf)){
            // アルファベットじゃなかった=ひらがなかカタカナだった
            const str = this.hunkaku2Zenkaku_str(alf);
            kana = kana + this.Hira2Kana(str);
          }else if(alf == "-" || alf == " "){
            kana = kana + alf;
          }
        }
      });
      
      formData.append('title', this.editDVD.title);
      formData.append('kana', kana);
      formData.append('duration_from', this.editDVD.duration_from);
      formData.append('duration_to', this.editDVD.duration_to);
      
      this.editDVD.locations.forEach(location => {
        if(location.prefecture){
          formData.append('location[' + count + '][id]', location.id ? location.id : '');
          formData.append('location[' + count + '][order]', location.order);
          formData.append('location[' + count + '][prefecture]', location.prefecture);
          formData.append('location[' + count + '][theater]', location.theater);
          count++;
        }
      });
      count = 0;
      
      formData.append('impression', this.editDVD.impression);
      formData.append('story', this.editDVD.story);
      formData.append('author', this.editDVD.author ? this.editDVD.author.replace(/\s+/g,'') : '');
      formData.append('costumer', this.editDVD.costumer ? this.editDVD.costumer.replace(/\s+/g,'') : '');      
      
      this.editDVD.costumers.forEach(costumer => {
        if(costumer.name){
          formData.append('costumer[' + count + '][id]', costumer.id ? costumer.id : '');
          formData.append('costumer[' + count + '][order]', costumer.order);
          formData.append('costumer[' + count + '][name]', costumer.name);
          count++;
        }
      });
      count = 0;
      
      formData.append('lyricist', this.editDVD.lyricist ? this.editDVD.lyricist.replace(/\s+/g,'') : '');
      formData.append('choreo', this.editDVD.choreo ? this.editDVD.choreo.replace(/\s+/g,'') : '');
      formData.append('director', this.editDVD.director ? this.editDVD.director.replace(/\s+/g,'') : '');
      
      this.editDVD.groups.forEach(group => {
        if(group.name){
          if(group.name.replace(/\s+/g,'')) {
            formData.append('group[' + count + '][id]', group.id ? group.id : '');
            formData.append('group[' + count + '][key]', group.key);
            formData.append('group[' + count + '][order]', group.order);
            formData.append('group[' + count + '][name]', group.name);
            count++;
          }            
        }
      });
      count = 0;
      
      this.editDVD.playerList.forEach(player => {
        if(player.player){
          if(player.player.replace(/\s+/g,'')) {
            const role = this.optionRoles.find(role => role.role == player.role);
            let role_impression;
            if(role) {
              role_impression = this.editDVD.roleImpressionList.find(roleImpression => roleImpression.role_key == role.key);
            }
            formData.append('role[' + count + '][id]', player.id ? player.id : '');
            formData.append('role[' + count + '][order]', player.order);
            formData.append('role[' + count + '][group_key]', player.group_key ? player.group_key : '');
            formData.append('role[' + count + '][role]', player.role ? player.role : '');
            formData.append('role[' + count + '][key]', player.key);
            formData.append('role[' + count + '][player]', player.player.replace(/\s+/g,''));
            formData.append('role[' + count + '][member]', player.member ? 1 : 0);
            formData.append('role[' + count + '][impression]', role_impression ? role_impression.impression ? role_impression.impression : '' : '');
            if(role_impression) {
              let count2 = 0;
              role_impression.photos.forEach(photo => {
                if(photo) {
                  formData.append('role[' + count + '][photo][' + count2 + '][id]', photo.id ? photo.id : '');
                  formData.append('role[' + count + '][photo][' + count2 + '][public_id]', photo.public_id ? photo.public_id : '');
                  formData.append('role[' + count + '][photo][' + count2 + '][url]', photo.url ? photo.url : '');
                  formData.append('role[' + count + '][photo][' + count2 + '][photo]', photo.photo ? photo.photo : '');
                  count2++  
                }        
              });              
            } else {
              formData.append('role[' + count + '][photo][' + 0 + '][id]', '');
              formData.append('role[' + count + '][photo][' + 0 + '][public_id]', '');
              formData.append('role[' + count + '][photo][' + 0 + '][url]', '');
              formData.append('role[' + count + '][photo][' + 0 + '][photo]', '');
            }
            count++;
          }            
        }
      });
      count = 0;
      
      this.editDVD.histories.forEach(history => {
        if(history.history) {
          if(history.history.replace(/\s+/g, '')) {
            let history_flag = 0;
            if(history.title) {
              if(history.title.replace(/\s+/g, '')) {
                history_flag = 1;
              } else if(this.editDVD.histories.length === 1) {
                history_flag = 1;
              }
            } else if(this.editDVD.histories.length === 1) {
              history_flag = 1;
            }

            if(history_flag) {
              formData.append('history[' + count + '][id]', history.id ? history.id : '');
              formData.append('history[' + count + '][order]', history.order);
              formData.append('history[' + count + '][title]', history.title ? history.title.replace(/\s+/g, '') : '');
              formData.append('history[' + count + '][history]', history.history);
              count++;
            }
          }
        }
      });
      count = 0
      
      this.editDVD.songs.forEach(song => {
        if(song.title){
          if(song.title.replace(/\s+/g,'')) {
            formData.append('song[' + count + '][id]', song.id ? song.id : '');
            formData.append('song[' + count + '][order]', song.order);
            formData.append('song[' + count + '][title]', song.title);
            formData.append('song[' + count + '][impression]', song.impression ? song.impression.replace(/\r+/g, '') : '');

            if(song.singers.length) {
              let count2 = 0;
              for(let k = 0; k < song.singers.length; k++) {
                const singer = song.singers[k];
                if(singer.role_key || singer.group_key || singer.name) {
                  let singerFlag = 0;
                  if(singer.role_key || singer.group_key) {
                    singerFlag = 1;
                  } else if(singer.name.replace(/\s+/g, '')) {
                    singerFlag = 1;
                  }

                  if(singerFlag) {
                    formData.append('song[' + count + '][singer][' + count2 + '][id]', singer.id ? singer.id : '');
                    formData.append('song[' + count + '][singer][' + count2 + '][order]', count2 + 1);
                    formData.append('song[' + count + '][singer][' + count2 + '][type]', singer.type);
                    if(singer.type === 'role') {
                      formData.append('song[' + count + '][singer][' + count2 + '][name]', singer.role_key);
                    } else if(singer.type === 'group') {
                      formData.append('song[' + count + '][singer][' + count2 + '][name]', singer.group_key);
                    } else if(singer.type === 'name') {
                      formData.append('song[' + count + '][singer][' + count2 + '][name]', singer.name.replace(/\s+/g, ''));
                    }                      
                    count2++;
                  }
                }
              }
            }
            count++;
          }
        }
      });
      count = 0
      
      this.editDVD.others.forEach(other => {
        let other_title_flag = 0;
        let other_impression_flag = 0;

        if(other.title) {
          if(other.title.replace(/\s+/g,'')) {
            other_title_flag = 1;
          }
        }

        if(other.impression){
          if(other.impression.replace(/\s+/g,'')) {
            other_impression_flag = 1;          
          }
        }

        if(other_title_flag || other_impression_flag) {
          formData.append('other[' + count + '][id]', other.id ? other.id : '');
          formData.append('other[' + count + '][order]', other.order);
          formData.append('other[' + count + '][title]', other_title_flag ? other.title : '');
          formData.append('other[' + count + '][impression]', other_impression_flag ? other.impression : '');
          count++;
        }
      });
      count = 0
      
      formData.append('photo[' + count + '][id]', this.editDVD.photos[0].id ? this.editDVD.photos[0].id : '');
      formData.append('photo[' + count + '][public_id]', this.editDVD.photos[0].public_id ? this.editDVD.photos[0].public_id : '');
      formData.append('photo[' + count + '][url]', this.editDVD.photos[0].url ? this.editDVD.photos[0].url : '');
      formData.append('photo[' + count + '][photo]', this.editDVD.photos[0].photo ? this.editDVD.photos[0].photo : '');

      formData.append('format', this.editDVD.format);
      formData.append('official', this.editDVD.official ? 1 : 0);
      formData.append('special', this.editDVD.special ? 1 : 0);
      formData.append('url_DVD', this.editDVD.url_DVD);
      formData.append('url_movie', this.editDVD.url_movie);
      formData.append('url_youtube', this.editDVD.url_youtube);
      formData.append('category', this.editDVD.category);

      const response = await axios.post('/api/DVD/' + this.DVD.id, formData);

      if (response.status === 422) {
        this.errors.error = response.data.errors;
        // メッセージ登録
        this.$store.commit('message/setContent', {
          content: '登録できませんでした',
          timeout: 6000
        });
        return false;
      }

      if (response.status !== 200) {
        this.$store.commit('error/setCode', response.status);
        // メッセージ登録
        this.$store.commit('message/setContent', {
          content: '登録できませんでした',
          timeout: 6000
        });
        return false;
      }

      // 諸々データ更新
      await this.fetchDVD();
      this.alterTab();
      
      window.scrollTo({
        top: 0,
        behavior: "smooth"
      });

      // メッセージ登録
      this.$store.commit('message/setContent', {
        content: 'DVDが登録されました！',
        timeout: 6000
      });

    },

    // 全角→半角（数字）
    Zenkaku2hankaku_number(str) {
      return str.replace(/[０-９]/g, function(s) {
        return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
      });
    },

    // 全角→半角（アルファベット）
    Zenkaku2hankaku_alf(str) {
      return str.replace(/[ａ-ｚＡ-Ｚ]/g, function(s) {
        return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
      });
    },

    // 半角→全角（カタカナ）
    hunkaku2Zenkaku_str(str) {
      const kanaMap = {
        'ｶﾞ': 'ガ', 'ｷﾞ': 'ギ', 'ｸﾞ': 'グ', 'ｹﾞ': 'ゲ', 'ｺﾞ': 'ゴ',
        'ｻﾞ': 'ザ', 'ｼﾞ': 'ジ', 'ｽﾞ': 'ズ', 'ｾﾞ': 'ゼ', 'ｿﾞ': 'ゾ',
        'ﾀﾞ': 'ダ', 'ﾁﾞ': 'ヂ', 'ﾂﾞ': 'ヅ', 'ﾃﾞ': 'デ', 'ﾄﾞ': 'ド',
        'ﾊﾞ': 'バ', 'ﾋﾞ': 'ビ', 'ﾌﾞ': 'ブ', 'ﾍﾞ': 'ベ', 'ﾎﾞ': 'ボ',
        'ﾊﾟ': 'パ', 'ﾋﾟ': 'ピ', 'ﾌﾟ': 'プ', 'ﾍﾟ': 'ペ', 'ﾎﾟ': 'ポ',
        'ｳﾞ': 'ヴ', 'ﾜﾞ': 'ヷ', 'ｦﾞ': 'ヺ',
        'ｱ': 'ア', 'ｲ': 'イ', 'ｳ': 'ウ', 'ｴ': 'エ', 'ｵ': 'オ',
        'ｶ': 'カ', 'ｷ': 'キ', 'ｸ': 'ク', 'ｹ': 'ケ', 'ｺ': 'コ',
        'ｻ': 'サ', 'ｼ': 'シ', 'ｽ': 'ス', 'ｾ': 'セ', 'ｿ': 'ソ',
        'ﾀ': 'タ', 'ﾁ': 'チ', 'ﾂ': 'ツ', 'ﾃ': 'テ', 'ﾄ': 'ト',
        'ﾅ': 'ナ', 'ﾆ': 'ニ', 'ﾇ': 'ヌ', 'ﾈ': 'ネ', 'ﾉ': 'ノ',
        'ﾊ': 'ハ', 'ﾋ': 'ヒ', 'ﾌ': 'フ', 'ﾍ': 'ヘ', 'ﾎ': 'ホ',
        'ﾏ': 'マ', 'ﾐ': 'ミ', 'ﾑ': 'ム', 'ﾒ': 'メ', 'ﾓ': 'モ',
        'ﾔ': 'ヤ', 'ﾕ': 'ユ', 'ﾖ': 'ヨ',
        'ﾗ': 'ラ', 'ﾘ': 'リ', 'ﾙ': 'ル', 'ﾚ': 'レ', 'ﾛ': 'ロ',
        'ﾜ': 'ワ', 'ｦ': 'ヲ', 'ﾝ': 'ン',
        'ｧ': 'ァ', 'ｨ': 'ィ', 'ｩ': 'ゥ', 'ｪ': 'ェ', 'ｫ': 'ォ',
        'ｯ': 'ッ', 'ｬ': 'ャ', 'ｭ': 'ュ', 'ｮ': 'ョ',
        '｡': '。', '､': '、', 'ｰ': 'ー', '｢': '「', '｣': '」', '･': '・'
      };
      let reg = new RegExp('(' + Object.keys(kanaMap).join('|') + ')', 'g');
      return str.replace(reg, function(s){
        return kanaMap[s];
      }).replace(/ﾞ/g, '゛').replace(/ﾟ/g, '゜');
    },

    // 文字列内のひらがなをカタカナに変換
    Hira2Kana(str) {
      return str.replace(/[\u3041-\u3096]/g, ch =>
        String.fromCharCode(ch.charCodeAt(0) + 0x60)
      );
    },

    // 削除ボタン
    confirmDeleteDVD() {
      this.showContent_confirm = true;
      this.dialog_confirm = '削除'
    },
    
    // 削除
    async deleteData() {
      const response = await axios.delete('/api/DVD/' + this.DVD.id);
      if (response.status === 204) {
        window.close();
      }
    },

    // 写真拡大
    openModal_photo(url) {
      this.showContent_photo = true;
      this.dialog_url = url;
    },
    closeModal_photo() {
      this.showContent_photo = false;
      this.dialog_url = '';
    },

    // フォーム関係
    // 劇場フォーム
    plusLocationForm() {
      if(this.editDVD.locations.length < 10) {
        // 追加
        this.editDVD.locations.push({
          id: null, order: this.editDVD.locations.length, prefecture: '', theater: null
        });

        if(this.editDVD.locations.length === 2) {
          this.$refs.detail_minus_button_area_locations_form.style.visibility = 'visible';
        } else if (this.editDVD.locations.length === 10) {
          this.$refs.detail_add_button_area_locations_form.style.visibility = 'hidden';
        }
      }
    },
    minusLocationForm() {
      if(this.editDVD.locations.length > 1) {
        // 削除
        this.editDVD.locations.pop();

        if(this.editDVD.locations.length === 1){
          this.$refs.detail_minus_button_area_locations_form.style.visibility = 'hidden';
        } else if (this.editDVD.locations.length === 9) {
          this.$refs.detail_add_button_area_locations_form.style.visibility = 'visible';
        }
      }
    },

    // 衣装フォーム
    plusCostumerForm() {
      if(this.editDVD.costumers.length < 5) {
        // 追加
        this.editDVD.costumers.push({
          id: null, order: this.editDVD.costumers.length, name: null
        });

        if(this.editDVD.costumers.length === 2) {
          this.$refs.detail_minus_button_area_costumers_form.style.visibility = 'visible';
        } else if (this.editDVD.locations.length === 5) {
          this.$refs.detail_add_button_area_costumers_form.style.visibility = 'hidden';
        }
      }
    },
    minusCostumerForm() {
      if(this.editDVD.costumers.length > 1) {
        // 削除
        this.editDVD.costumers.pop();

        if(this.editDVD.costumers.length === 1){
          this.$refs.detail_minus_button_area_costumers_form.style.visibility = 'hidden';
        } else if (this.editDVD.costumers.length === 4) {
          this.$refs.detail_add_button_area_costumers_form.style.visibility = 'visible';
        }
      }
    },

    // 出演者フォーム
    plusPlayerForm() {
      if(this.editDVD.playerList.length < 50) {
        // 追加
        if(!this.playerFlag){
          this.editDVD.playerList.push({
            id: null, key: this.getUniqueStr(), order:this.editDVD.playerList.length, group_key: '', group_id: null, role: '', player: '', member: false
          });
        }
        this.playerFlag = false;

        if(this.editDVD.playerList.length === 2) {
          this.$refs.detail_minus_button_area_players_form.style.visibility = 'visible';
        } else if (this.editDVD.playerList.length === 50) {
          this.$refs.detail_add_button_area_players_form.style.visibility = 'hidden';
        }

        if(this.editDVD.playerList.length === 2) {
          this.$refs.detail_minus_button_area_players_form.style.visibility = 'visible';
        } else if (this.editDVD.playerList.length === 50) {
          this.$refs.detail_add_button_area_players_form.style.visibility = 'hidden';
        }

        if(this.editDVD.groups.length < this.editDVD.playerList.length && this.editDVD.groups.length < 5) {
          this.$refs.detail_add_button_area_groups_form.style.visibility = 'visible';
        }

        if(this.editDVD.roleImpressionList.length < this.editDVD.playerList.length && this.editDVD.roleImpressionList.length < 50) {
          this.$refs.detail_add_button_area_role_impressions_form.style.visibility = 'visible';
        }
      }
    },
    minusPlayerForm() {
      if(this.editDVD.playerList.length > 1) {
        // 削除
        const popPlayer = this.editDVD.playerList.pop();
        if(popPlayer.role) {
          const popRole = this.optionRoles.pop();
          this.editDVD.roleImpressionList.forEach(roleImpression => {
            if(roleImpression.role_key === popRole.key) {
              roleImpression.role_key = "";
            }
          });
        }

        if(this.editDVD.playerList.length === 1){
          this.$refs.detail_minus_button_area_players_form.style.visibility = 'hidden';
        } else if (this.editDVD.playerList.length === 49) {
          this.$refs.detail_add_button_area_players_form.style.visibility = 'visible';
        }

        if(this.editDVD.groups.length > this.editDVD.playerList.length) {
          this.minusGroupForm();
          this.$refs.detail_add_button_area_groups_form.style.visibility = 'hidden';
        } else if(this.editDVD.groups.length === this.editDVD.playerList.length) {
          this.$refs.detail_add_button_area_groups_form.style.visibility = 'hidden';
        }

        if(this.editDVD.roleImpressionList.length > this.editDVD.playerList.length) {
          this.minusRoleImpressionForm();
          this.$refs.detail_add_button_area_role_impressions_form.style.visibility = 'hidden';
        } else if(this.editDVD.roleImpressionList.length === this.editDVD.playerList.length) {
          this.$refs.detail_add_button_area_role_impressions_form.style.visibility = 'hidden';
        }
      }
    },
    // 移動したら
    endMovePlayer() {
      this.editDVD.playerList.forEach((player, index) => {
        player.order = index;
        const optionRoleIndex = this.optionRoles.findIndex(optionRole => optionRole.key === player.key);
        const roleImpressionIndex = this.editDVD.roleImpressionList.findIndex(roleImpression => roleImpression.role_key === player.key);
        if(optionRoleIndex > -1) {
          this.optionRoles[optionRoleIndex].order = index;
        }

        if(roleImpressionIndex > -1) {
          this.editDVD.roleImpressionList[roleImpressionIndex].order = index;
        }
      });

      this.optionRoles.sort(function(a, b) {
        return a.order - b.order;
      });
      this.editDVD.roleImpressionList.sort(function(a, b) {
        return a.order - b.order;
      });
    },

    // 分類フォーム
    plusGroupForm() {
      if(this.editDVD.groups.length < 10) {
        // 追加
        this.editDVD.groups.push({
          id: null, key: this.getUniqueStr(), order: this.editDVD.groups.length, name: ''
        });
        
        if(this.editDVD.groups.length === 2){
          this.$refs.detail_minus_button_area_groups_form.style.visibility = 'visible';
        } else if(this.editDVD.groups.length === 10) {
          this.$refs.detail_add_button_area_groups_form.style.visibility = 'hidden';
        } 
        
        if(this.editDVD.groups.length >= this.editDVD.playerList.length || this.editDVD.groups.length === 10) {
          this.$refs.detail_add_button_area_groups_form.style.visibility = 'hidden';
        } else if (this.editDVD.groups.length < 10 && this.editDVD.groups.length < this.editDVD.playerList.length) {
          this.$refs.detail_add_button_area_groups_form.style.visibility = 'visible';
        }
      }
    },
    minusGroupForm() {
      if(this.editDVD.groups.length > 1) {
        // 削除
        const popGroup = this.editDVD.groups.pop();
        if(popGroup.name) {
          this.optionGroups.pop();
          this.editDVD.playerList.forEach(player => {
            if(player.group_key === popGroup.key) {
              player.group_key = "";
            }
          });
        }

        if(this.editDVD.groups.length === 1){
          this.$refs.detail_minus_button_area_groups_form.style.visibility = 'hidden';
        } else if(this.editDVD.groups.length === 9) {
          this.$refs.detail_add_button_area_groups_form.style.visibility = 'visible';
        }
        
        if(this.editDVD.groups.length >= this.editDVD.playerList.length || this.editDVD.groups.length === 10) {
          this.$refs.detail_add_button_area_groups_form.style.visibility = 'hidden';
        } else if (this.editDVD.groups.length < 10 && this.editDVD.groups.length < this.editDVD.playerList.length) {
          this.$refs.detail_add_button_area_groups_form.style.visibility = 'visible';
        }
      }
    },
    // 動かしたら
    endMoveGroup() {
      this.editDVD.groups.forEach((group, index) => {
        group.order = index;
        const optionGroupIndex = this.optionGroups.findIndex(optionGroup => optionGroup.key == group.key);
        if(optionGroupIndex > -1) {
          this.optionGroups[optionGroupIndex].order = index;
        }
      });

      this.optionGroups.sort(function(a, b) {
        return a.order - b.order;
      });
    },

    // 出演者感想フォーム
    plusRoleImpressionForm() {
      if(this.editDVD.roleImpressionList.length < 50 && this.editDVD.roleImpressionList.length < this.editDVD.playerList.length) {
        // 追加
        this.editDVD.roleImpressionList.push({
          id: null, order: null, role_key: "", impression: '', photos: [{photo: 0}]
        });

        if(this.editDVD.roleImpressionList.length === 2){
          this.$refs.detail_minus_button_area_role_impressions_form.style.visibility = 'visible';
        } else if(this.editDVD.roleImpressionList.length === 50) {
          this.$refs.detail_add_button_area_role_impressions_form.style.visibility = 'hidden';
        } 
        
        if(this.editDVD.roleImpressionList.length >= this.editDVD.playerList.length || this.editDVD.roleImpressionList.length === 50) {
          this.$refs.detail_add_button_area_role_impressions_form.style.visibility = 'hidden';
        } else if (this.editDVD.roleImpressionList.length < 50 && this.editDVD.roleImpressionList.length < this.editDVD.playerList.length) {
          this.$refs.detail_add_button_area_role_impressions_form.style.visibility = 'visible';
        }
      }
    },
    minusRoleImpressionForm() {
      if(this.editDVD.roleImpressionList.length > 1) {
        // 削除
        this.editDVD.roleImpressionList.pop();

        if(this.editDVD.roleImpressionList.length === 1){
          this.$refs.detail_minus_button_area_role_impressions_form.style.visibility = 'hidden';
        } else if(this.editDVD.roleImpressionList.length === 49) {
          this.$refs.detail_add_button_area_role_impressions_form.style.visibility = 'visible';
        } 

        if(this.editDVD.roleImpressionList.length >= this.editDVD.playerList.length || this.editDVD.roleImpressionList.length === 50) {
          this.$refs.detail_add_button_area_role_impressions_form.style.visibility = 'hidden';
        } else if (this.editDVD.roleImpressionList.length < 50 && this.editDVD.roleImpressionList.length < this.editDVD.playerList.length) {
          this.$refs.detail_add_button_area_role_impressions_form.style.visibility = 'visible';
        }
      }
    },
    // 役を選んだら
    chooseRole: function(index) {
      const key = this.editDVD.roleImpressionList[index].role_key;
      const chosePlayer = this.editDVD.playerList.find(player => player.key === key);
      this.editDVD.roleImpressionList[index].order = chosePlayer.order;
    },

    // 歴史フォーム
    plusHistoryForm() {
      if(this.editDVD.histories.length < 10) {
        // 追加
        this.editDVD.histories.push({
          id: null, order: this.editDVD.histories.length, title: null, history: null
        });

        if(this.editDVD.histories.length === 2) {
          this.$refs.detail_minus_button_area_histories_form.style.visibility = 'visible';
        } else if (this.editDVD.histories.length === 10) {
          this.$refs.detail_add_button_area_histories_form.style.visibility = 'hidden';
        }
      }
    },
    minusHistoryForm() {
      if(this.editDVD.histories.length > 1) {
        // 削除
        this.editDVD.histories.pop();

        if(this.editDVD.histories.length === 1){
          this.$refs.detail_minus_button_area_histories_form.style.visibility = 'hidden';
        } else if (this.editDVD.histories.length === 9) {
          this.$refs.detail_add_button_area_histories_form.style.visibility = 'visible';
        }
      }
    },

    // 歌フォーム
    plusSongForm() {
      if(this.editDVD.songs.length < 10) {
        // 追加
        this.editDVD.songs.push({
          id: null, order: this.editDVD.songs.length, title: null, singers: [{order: '', type: 'role', role_key: '', role_id: null, group_key: '', group_id: null, name: null}], impression: null
        });

        if(this.editDVD.songs.length === 2) {
          this.$refs.detail_minus_button_area_songs_form.style.visibility = 'visible';
        } else if (this.editDVD.songs.length === 10) {
          this.$refs.detail_add_button_area_songs_form.style.visibility = 'hidden';
        }
      }
    },
    minusSongForm() {
      if(this.editDVD.songs.length > 1) {
        // 削除
        this.editDVD.songs.pop();

        if(this.editDVD.songs.length === 1){
          this.$refs.detail_minus_button_area_songs_form.style.visibility = 'hidden';
        } else if (this.editDVD.songs.length === 9) {
          this.$refs.detail_add_button_area_songs_form.style.visibility = 'visible';
        }
      }
    },
    endMoveSong() {
      this.editDVD.songs.forEach((song, index) => {
        const addButton = 'detail_add_button_area_singers_form_' + index;
        const minusButton = 'detail_minus_button_area_singers_form_' + index;
        if(song.singers.length > 1) {
          this.$refs[minusButton].style.visibility = 'visible';
        } else {
          this.$refs[minusButton].style.visibility = 'hidden';
        }
        if(song.singers.length < 10) {
          this.$refs[addButton].style.visibility = 'visible';
        } else {
          this.$refs[addButton].style.visibility = 'hidden';
        }
      });
    },

    // 歌手フォーム
    plusSingerForm(songIndex) {
      if(this.editDVD.songs[songIndex].singers.length < 10) {
        // 追加
        this.editDVD.songs[songIndex].singers.push({
          order: '', type: 'role', role_key: '', role_id: null, group_key: '', group_id: null, name: null
        });

        const addButton = 'detail_add_button_area_singers_form_' + songIndex;
        const minusButton = 'detail_minus_button_area_singers_form_' + songIndex;

        if(this.editDVD.songs[songIndex].singers.length === 2) {
          this.$refs[minusButton].style.visibility = 'visible';
        } else if (this.editDVD.songs[songIndex].singers.length === 10) {
          this.$refs[addButton].style.visibility = 'hidden';
        }
      }
    },
    minusSingerForm(songIndex) {
      if(this.editDVD.songs[songIndex].singers.length > 1) {
        // 削除
        this.editDVD.songs[songIndex].singers.pop();

        const addButton = 'detail_add_button_area_singers_form_' + songIndex;
        const minusButton = 'detail_minus_button_area_singers_form_' + songIndex;

        if(this.editDVD.songs[songIndex].singers.length === 1){
          this.$refs[minusButton].style.visibility = 'hidden';
        } else if (this.editDVD.songs[songIndex].singers.length === 9) {
          this.$refs[addButton].style.visibility = 'visible';
        }
      }
    },

    // その他フォーム
    plusOtherForm() {
      if(this.editDVD.others.length < 10) {
        // 追加
        this.editDVD.others.push({
          id: null, order: this.editDVD.others.length, title: null, impression: null
        });

        if(this.editDVD.others.length === 2) {
          this.$refs.detail_minus_button_area_others_form.style.visibility = 'visible';
        } else if (this.editDVD.others.length === 10) {
          this.$refs.detail_add_button_area_others_form.style.visibility = 'hidden';
        }
      }
    },
    minusOtherForm() {
      if(this.editDVD.others.length > 1) {
        // 削除
        this.editDVD.others.pop();

        if(this.editDVD.others.length === 1){
          this.$refs.detail_minus_button_area_others_form.style.visibility = 'hidden';
        } else if (this.editDVD.others.length === 9) {
          this.$refs.detail_add_button_area_others_form.style.visibility = 'visible';
        }
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