<template>
  <div class="add">
    <form @submit.prevent="regiterData" class="add-form">
      <div class="add-block">
        <div class="add-block-1">
          <!-- タイトル -->
          <div class="add-area add-title-area">
            <div class="add-header">
              タイトル
            </div>
            <div class="add-title-kana-area">
              <input type="text" id="add_title" v-model="registerForm.title" class="add-title" placeholder="タイトル" @input="getTitle" required>
              <input type="text" v-model="registerForm.kana" class="add-title add-title-kana" placeholder="タイトル" required>
            </div>
              
          </div>

          <!-- 公演期間 -->
          <div class="add-area add-duration-area">
            <div class="add-header">
              公演期間
            </div>
            <div class="add-duration-input-area">
              <input type="date" v-model="registerForm.durationFrom" class="add-duration"> 
              <div class="add-duration-conection">
                  ~
              </div>
              <input type="date" v-model="registerForm.durationTo" class="add-duration add-duration-2"> 
            </div>
          </div>

          <!-- 公演場所 -->
          <div class="add-area add-location-area">
            <div class="add-header">
              公演場所
            </div>
            
            <div class="add-locations-button-area">
              <draggable v-model="registerForm.locationList" group="locationList" item-key="key" tag="section" class="add-locations">
                <!-- 1セット -->
                <template #item="{element : location}">
                  <div class="add-location">
                    <select :ref="'add_location_prefecture_' + index" class="add-location-prefecture" v-model="location.prefecture">
                      <option value="" disabled>選択</option>
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
                <div ref="add_minus_button_area_locations_form" class="add-minus-button-area">
                  <button type="button" class="add-add-button" @click="minusLocationForm">
                    <div class="add-add-button-icon">
                      <i class="fa-solid fa-minus"></i>
                    </div>
                  </button>
                </div>
                <div ref="add_add_button_area_locations_form" class="add-add-button-area">
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
            <textarea v-model="registerForm.impression" class="add-impression" placeholder="どうだった？"></textarea>
          </div>

          <!-- あらすじ -->
          <div class="add-area add-story-area">
            <div class="add-header">
              あらすじ
            </div>
            <textarea v-model="registerForm.story" class="add-story" placeholder="あらすじ"></textarea>
          </div>

          <!-- 脚本 -->
          <div class="add-area add-author-area">
            <div class="add-header">
              戯曲
            </div>
            <input type="text" v-model="registerForm.author" class="add-author">
          </div>

          <!-- 衣装 -->
          <div class="add-area add-author-area">
            <div class="add-header">
              衣装
            </div>

            <div class="add-costumers-button-block">
              <!-- 中身 -->
              <div class="add-costumers-bodyblock">
                <draggable v-model="registerForm.costumerList" group="costumerList" item-key="key" tag="section" class="add-costumers-costumerline">
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
                <div ref="add_minus_button_area_costumers_form" class="add-minus-button-area" style="visibility: hidden">
                  <button type="button" class="add-add-button" @click="minusCostumerForm">
                    <div class="add-add-button-icon">
                      <i class="fa-solid fa-minus"></i>
                    </div>
                  </button>
                </div>
                <div ref="add_add_button_area_costumers_form" class="add-add-button-area">
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
            <input type="text" v-model="registerForm.lyricist" class="add-author">
          </div>

          <!-- 振付 -->
          <div class="add-area add-author-area">
            <div class="add-header">
              振付
            </div>
            <input type="text" v-model="registerForm.choreo" class="add-author">
          </div>

          <!-- ゲキ×シネ監督 -->
          <div class="add-area add-author-area">
            <div class="add-header add-header-director">
              ゲキ×シネ監督
            </div>
            <input type="text" v-model="registerForm.director" class="add-author">
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
                <!-- 表<大きい用> -->
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
                    <draggable v-model="registerForm.playerList" group="playerList" item-key="key" tag="section" @end="endMovePlayer">
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
                            <input type="checkbox" class="add-players-input add-players-member" v-model="player.member">
                          </div>
                        </div>
                      </template>
                    </draggable>                      
                  </div>
                </div>

                <!-- 表<小さい用> -->
                <draggable v-model="registerForm.playerList" group="playerList" item-key="key" tag="section" @end="endMovePlayer" class="add-players-box-small">
                  <!-- 1セット -->
                  <template #item="{element: player, index: index}">                        
                    <div class="add-players-bodyblock">
                      <!-- ヘッダー -->
                      <div class="add-players-small-header">
                        {{ index + 1 }}.
                      </div>

                      <!-- 中身 -->
                      <div class="add-players-playerline">
                        <div class="add-players-small-set">
                          <div class="add-players-cell add-players-header-cell">
                            分類
                          </div>
                          <div class="add-players-cell add-players-line-cell">
                            <select class="add-players-input add-players-input-text add-players-group" v-model="player.group_key">
                              <option value="">選択</option>
                              <option v-for="group in optionGroups" 
                                :value="group.key" :key="group.key">
                                {{ group.name }}
                              </option>
                            </select>
                          </div>
                        </div>

                        <div class="add-players-small-set">
                          <div class="add-players-cell add-players-header-cell">
                            役名
                          </div>
                          <div class="add-players-cell add-players-line-cell">
                            <input type="text" class="add-players-input add-players-input-text add-players-role" v-model="player.role" @input="getRole(player.key)">
                          </div>
                        </div>

                        <div class="add-players-small-set">
                          <div class="add-players-cell add-players-header-cell">
                            役者
                          </div>
                          <div class="add-players-cell add-players-line-cell">
                            <input type="text" class="add-players-input add-players-input-text add-players-player" v-model="player.player">
                          </div>
                        </div>

                        <div class="add-players-small-set">
                          <div class="add-players-cell add-players-header-cell">
                            劇団員
                          </div>
                          <div class="add-players-cell add-players-line-cell">
                            <input type="checkbox" class="add-players-input add-players-member" v-model="player.member">
                          </div>
                        </div>

                      </div>
                    </div>
                  </template>
                </draggable>

                <!-- フォームボタン -->
                <div class="add-add-minus-button-area">
                  <div ref="add_minus_button_area_players_form" class="add-minus-button-area" style="visibility: hidden">
                    <button type="button" class="add-add-button" @click="minusPlayerForm">
                      <div class="add-add-button-icon">
                        <i class="fa-solid fa-minus"></i>
                      </div>
                    </button>
                  </div>
                  <div ref="add_add_button_area_players_form" class="add-add-button-area">
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
                    <draggable v-model="registerForm.groupList" group="groupList" item-key="key" tag="section" @end="endMoveGroup">
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
                  <div ref="add_minus_button_area_groups_form" class="add-minus-button-area" style="visibility: hidden">
                    <button type="button" class="add-add-button" @click="minusGroupForm">
                      <div class="add-add-button-icon">
                        <i class="fa-solid fa-minus"></i>
                      </div>
                    </button>
                  </div>
                  <div ref="add_add_button_area_groups_form" class="add-add-button-area" style="visibility: hidden">
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
            <!-- 表<大きい用> -->
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
                <section v-for="(roleImpression, roleImpressionIndex) in registerForm.roleImpressionList" :key="roleImpressionIndex">
                  <!-- 1セット -->
                  <div class="add-role-impressions-bodyline">
                    <div class="add-roles-impressions-cell add-role-impressions-body-cell add-role-impressions-cell-role">
                      <select class="add-role-impressions-input add-role-impressions-role" v-model="roleImpression.role_key" @change="chooseRole(roleImpressionIndex)">
                        <option value="">選択</option>
                        <option v-for="role in optionRoles" 
                          :value="role.key" :key="role.key">
                          {{ role.role }}
                        </option>
                      </select>
                    </div>
                    <div class="add-roles-impressions-cell add-role-impressions-body-cell add-role-impressions-cell-impression">
                      <textarea class="add-role-impressions-input add-role-impressions-impression" v-model="roleImpression.impression" placeholder="どうだった？"></textarea>  
                    </div>
                    <div class="add-roles-impressions-cell add-role-impressions-body-cell add-role-impressions-cell-photo">
                     <draggable v-model="roleImpression.photoList" group="roleImpressionPhotoList" item-key="key" tag="section" class="add-role-impression-photos-block">
                         <!-- 1セット -->
                        <template #item="{element : photo, index: roleImpressionPhotoIndex}">
                         <div class="add-photo-block">
                            <label :for="'add_role_impressions_photo_large_' + roleImpressionIndex + '_' + roleImpressionPhotoIndex" class="add-role-impressions-input add-role-impressions-photo-button">選択</label>
                            <input type="file" :id="'add_role_impressions_photo_large_' + roleImpressionIndex + '_' + roleImpressionPhotoIndex" class="add-role-impressions-photo" @change="previewFileRoleImpression(roleImpressionIndex, roleImpressionPhotoIndex, $event)">
                            <div class="add-role-impressions-photo-area">
                              <output v-if="photo.preview" class="add-role-impressions-photo-output">
                                <button type="button" class="add-role-impressions-photo-resetbutton" @click="resetPhotoRoleImpression(roleImpressionIndex, roleImpressionPhotoIndex)"><i class="fa-solid fa-xmark"></i></button>
                                <img :src="photo.preview" alt="" class="add-role-impressions-photo-preview" >
                              </output>
                              
                              <div v-if="errors.roleImpressions[roleImpressionIndex].photos[roleImpressionPhotoIndex]" class="add-error-message-role-impressions-photo">{{ errors.roleImpressions[roleImpressionIndex].photos[roleImpressionPhotoIndex] }}</div>
                            </div>
                          </div>
                        </template>
                      </draggable>
                    
                      <!-- フォームボタン -->
                      <div class="add-add-minus-button-area add-add-minus-button-area-small">
                        <div ref="add_minus_button_area_role_impression_photos_form_large" class="add-minus-button-area add-minus-button-area-small" style="visibility: hidden">
                          <button type="button" class="add-add-button add-add-button-small" @click="minusRoleImpressionPhotoForm(roleImpressionIndex)">
                            <div class="add-add-button-icon add-add-button-icon-small">
                              <i class="fa-solid fa-minus"></i>
                            </div>
                          </button>
                        </div>
                        <div ref="add_add_button_area_role_impression_photos_form_large" class="add-add-button-area add-minus-button-area-small">
                          <button type="button" class="add-add-button add-add-button-small" @click="plusRoleImpressionPhotoForm(roleImpressionIndex)">
                            <div class="add-add-button-icon add-add-button-icon-small">
                              <i class="fa-solid fa-plus"></i>
                            </div>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
              </div>
            </div>

            <!-- 表<小さい用> -->
            <section v-for="(roleImpression, roleImpressionIndex) in registerForm.roleImpressionList" :key="roleImpressionIndex" class="add-role-impressions-box-small">
              <!-- 1セット -->
              <div id="add_role_impressions_bodyblock" class="add-role-impression-bodyblock">
                <div class="add-role-impressions-small-header">
                  {{ roleImpressionIndex + 1 }}.
                </div>
                <!-- 中身 -->
                <div class="add-role-impressions-bodyline">
                  <div class="add-role-impressions-small-set">
                    <div class="add-roles-impressions-cell add-role-impressions-header-cell">
                      役名
                    </div>
                    <div class="add-roles-impressions-cell add-role-impressions-body-cell">
                      <select class="add-role-impressions-input add-role-impressions-role" v-model="roleImpression.role_key" @change="chooseRole(roleImpressionIndex)">
                        <option value="">選択</option>
                        <option v-for="role in optionRoles" 
                          :value="role.key" :key="role.key">
                          {{ role.role }}
                        </option>
                      </select>
                    </div>
                  </div>

                  <div class="add-role-impressions-small-set add-role-impressions-impression-cell">
                    <div class="add-roles-impressions-cell add-role-impressions-header-cell add-role-impressions-impression-cell">
                      感想
                    </div>
                    <div class="add-roles-impressions-cell add-role-impressions-body-cell add-role-impressions-impression-cell">
                      <textarea class="add-role-impressions-input add-role-impressions-impression" v-model="roleImpression.impression" placeholder="どうだった？"></textarea>  
                    </div>
                  </div>                    
                  
                  <div class="add-role-impressions-small-set add-role-impressions-photos-cell">
                    <div class="add-roles-impressions-cell add-role-impressions-header-cell add-role-impressions-photos-cell">
                      写真
                    </div>
                    <div class="add-roles-impressions-cell add-role-impressions-body-cell">
                      <draggable v-model="roleImpression.photoList" group="roleImpressionPhotoList" item-key="key" tag="section" class="add-role-impression-photos-block">
                        <!-- 1セット -->
                        <template #item="{element : photo, index: roleImpressionPhotoIndex}">
                        <div class="add-photo-block">
                            <label :for="'add_role_impressions_photo_small_' + roleImpressionIndex + '_' + roleImpressionPhotoIndex" class="add-role-impressions-input add-role-impressions-photo-button">選択</label>
                            <input type="file" :id="'add_role_impressions_photo_small_' + roleImpressionIndex + '_' + roleImpressionPhotoIndex" class="add-role-impressions-photo" @change="previewFileRoleImpression(roleImpressionIndex, roleImpressionPhotoIndex, $event)">
                            <div class="add-role-impressions-photo-area">
                              <output v-if="photo.preview" class="add-role-impressions-photo-output">
                                <button type="button" class="add-role-impressions-photo-resetbutton" @click="resetPhotoRoleImpression(roleImpressionIndex, roleImpressionPhotoIndex)"><i class="fa-solid fa-xmark"></i></button>
                                <img :src="photo.preview" alt="" class="add-role-impressions-photo-preview" >
                              </output>
                              
                              <div v-if="errors.roleImpressions[roleImpressionIndex].photos[roleImpressionPhotoIndex]" class="add-error-message-role-impressions-photo">{{ errors.roleImpressions[roleImpressionIndex].photos[roleImpressionPhotoIndex] }}</div>
                            </div>
                          </div>
                        </template>
                      </draggable>
                    
                      <!-- フォームボタン -->
                      <div class="add-add-minus-button-area add-add-minus-button-area-small">
                        <div ref="add_minus_button_area_role_impression_photos_form_small" class="add-minus-button-area add-minus-button-area-small" style="visibility: hidden">
                          <button type="button" class="add-add-button add-add-button-small" @click="minusRoleImpressionPhotoForm(roleImpressionIndex)">
                            <div class="add-add-button-icon add-add-button-icon-small">
                              <i class="fa-solid fa-minus"></i>
                            </div>
                          </button>
                        </div>
                        <div ref="add_add_button_area_role_impression_photos_form_small" class="add-add-button-area add-minus-button-area-small">
                          <button type="button" class="add-add-button add-add-button-small" @click="plusRoleImpressionPhotoForm(roleImpressionIndex)">
                            <div class="add-add-button-icon add-add-button-icon-small">
                              <i class="fa-solid fa-plus"></i>
                            </div>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <!-- フォームボタン -->
            <div class="add-add-minus-button-area">
              <div ref="add_minus_button_area_role_impressions_form" class="add-minus-button-area" style="visibility: hidden">
                <button type="button" class="add-add-button" @click="minusRoleImpressionForm">
                  <div class="add-add-button-icon">
                    <i class="fa-solid fa-minus"></i>
                  </div>
                </button>
              </div>
              <div ref="add_add_button_area_role_impressions_form" class="add-add-button-area" style="visibility: hidden">
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
              <!-- 表<大きい用> -->
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
                  <draggable v-model="registerForm.historyList" group="historyList" item-key="key" tag="section">
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

              <!-- 表<小さい用> -->
              <draggable v-model="registerForm.historyList" group="historyList" item-key="key" tag="section" class="add-others-box-small">                    
                <template #item="{element: history, index: index}">
                  <!-- 1セット -->
                  <div class="add-others-bodyblock">
                    <!-- ヘッダー -->
                    <div class="add-others-small-header">
                      {{ index + 1 }}.
                    </div>

                    <!-- 中身 -->
                    <div class="add-others-bodyline">
                      <div class="add-others-small-set">
                        <div class="add-others-cell add-others-header-cell">
                          題名
                        </div>
                        <div class="add-others-cell add-others-body-cell">
                          <input type="text" class="add-others-input add-others-title" v-model="history.title">
                        </div>
                      </div>

                      <div class="add-others-small-set add-others-impression-cell">
                        <div class="add-others-cell add-others-header-cell add-others-impression-cell">
                          歴史
                        </div>
                        <div class="add-others-cell add-others-body-cell add-others-impression-cell">
                          <textarea class="add-others-input add-others-impression" placeholder="本当は？" v-model="history.history"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </template>
              </draggable>

              <!-- フォームボタン -->
              <div class="add-add-minus-button-area">
                <div ref="add_minus_button_area_histories_form" class="add-minus-button-area" style="visibility: hidden">
                  <button type="button" class="add-add-button" @click="minusHistoryForm">
                    <div class="add-add-button-icon">
                      <i class="fa-solid fa-minus"></i>
                    </div>
                  </button>
                </div>
                <div ref="add_add_button_area_histories_form" class="add-add-button-area">
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
              <!-- 表<大きい用> -->
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
                  <draggable v-model="registerForm.songList" group="songList" item-key="key" tag="section" @end="endMoveSong">
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
                                      <label :for="'add_song_role_' + songIndex + '_' + singIndex">キャスト</label>
                                      <input :id="'add_song_role_' + songIndex + '_' + singIndex" type="radio" class="add-song-singer-type-radio" value="role" v-model="singer.type">
                                    </div>
                                    <div class="add-song-singer-type-box">
                                      <label :for="'add_song_group_' + songIndex + '_' + singIndex">分類</label>
                                      <input :id="'add_song_group_' + songIndex + '_' + singIndex" type="radio" class="add-song-singer-type-radio" value="group" v-model="singer.type">
                                    </div>
                                    <div class="add-song-singer-type-box">
                                      <label :for="'add_song_input_' + songIndex + '_' + singIndex">入力</label>
                                      <input :id="'add_song_input_' + songIndex + '_' + singIndex" type="radio" class="add-song-singer-type-radio" value="name" v-model="singer.type">
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
                              <div :ref="'add_minus_button_area_singers_form_' + songIndex" class="add-minus-button-area add-minus-button-area-small" style="visibility: hidden">
                                <button type="button" class="add-add-button add-add-button-small" @click="minusSingerForm(songIndex)">
                                  <div class="add-add-button-icon add-add-button-icon-small">
                                    <i class="fa-solid fa-minus"></i>
                                  </div>
                                </button>
                              </div>
                              <div :ref="'add_add_button_area_singers_form_' + songIndex" class="add-add-button-area add-minus-button-area-small">
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

              <!-- 表<小さい用> -->
              <draggable v-model="registerForm.songList" group="songList" item-key="key" tag="section" @end="endMoveSong" class="add-others-box-small">
                <!-- 1セット -->
                <template #item="{element : song, index: songIndex}">
                  <div class="add-others-bodyblock">
                    <div class="add-others-small-header">
                      {{ songIndex + 1 }}.
                    </div>

                    <!-- 中身 -->
                    <div class="add-others-bodyline">
                      <div class="add-others-small-set">
                        <div class="add-others-cell add-others-header-cell add-others-cell-title">
                          題名
                        </div>
                        <div class="add-others-cell add-others-body-cell add-others-cell-title">
                          <input type="text" class="add-others-input add-others-title" v-model="song.title">
                        </div>
                      </div>

                      <div class="add-others-small-set add-others-singers-cell">
                        <div class="add-others-cell add-others-header-cell add-songs-cell-singer">
                          歌い手
                        </div>
                        <div class="add-others-cell add-others-body-cell add-songs-cell-singer add-singers-body-cell-singer">
                          <div class="add-song-singer-area">
                            <draggable v-model="song.singers" group="songList_singers" item-key="key" tag="section">
                              <template #item="{element : singer, index: singIndex}">
                                <div class="add-song-singers-area">
                                  <div class="add-song-singer-type-area">
                                    <div class="add-song-singer-type-box">
                                      <label :for="'add_song_role_' + songIndex + '_' + singIndex">キャスト</label>
                                      <input :id="'add_song_role_' + songIndex + '_' + singIndex" type="radio" class="add-song-singer-type-radio" value="role" v-model="singer.type">
                                    </div>
                                    <div class="add-song-singer-type-box">
                                      <label :for="'add_song_group_' + songIndex + '_' + singIndex">分類</label>
                                      <input :id="'add_song_group_' + songIndex + '_' + singIndex" type="radio" class="add-song-singer-type-radio" value="group" v-model="singer.type">
                                    </div>
                                    <div class="add-song-singer-type-box">
                                      <label :for="'add_song_input_' + songIndex + '_' + singIndex">入力</label>
                                      <input :id="'add_song_input_' + songIndex + '_' + singIndex" type="radio" class="add-song-singer-type-radio" value="name" v-model="singer.type">
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
                              <div :ref="'add_minus_button_area_singers_form_' + songIndex" class="add-minus-button-area add-minus-button-area-small" style="visibility: hidden">
                                <button type="button" class="add-add-button add-add-button-small" @click="minusSingerForm(songIndex)">
                                  <div class="add-add-button-icon add-add-button-icon-small">
                                    <i class="fa-solid fa-minus"></i>
                                  </div>
                                </button>
                              </div>
                              <div :ref="'add_add_button_area_singers_form_' + songIndex" class="add-add-button-area add-minus-button-area-small">
                                <button type="button" class="add-add-button add-add-button-small" @click="plusSingerForm(songIndex)">
                                  <div class="add-add-button-icon add-add-button-icon-small">
                                    <i class="fa-solid fa-plus"></i>
                                  </div>
                                </button>
                              </div>
                            </div>
                          </div>  
                        </div>
                      </div>

                      <div class="add-others-small-set add-others-impression-cell">
                        <div class="add-others-cell add-others-header-cell add-songs-cell-impression">
                          感想
                        </div>
                        <div class="add-others-cell add-others-body-cell add-songs-cell-impression">
                          <textarea class="add-others-input add-others-impression" placeholder="どうだった？" v-model="song.impression"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </template>
              </draggable>

              <!-- フォームボタン -->
              <div class="add-add-minus-button-area">
                <div ref="add_minus_button_area_songs_form" class="add-minus-button-area" style="visibility: hidden">
                  <button type="button" class="add-add-button" @click="minusSongForm">
                    <div class="add-add-button-icon">
                      <i class="fa-solid fa-minus"></i>
                    </div>
                  </button>
                </div>
                <div ref="add_add_button_area_songs_form" class="add-add-button-area">
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
              <!-- 表<大きい用> -->
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
                  <draggable v-model="registerForm.otherList" group="otherList" item-key="key" tag="section">
                    <!-- 1セット -->
                    <template #item="{element : other}">
                      <div class="add-others-bodyline">
                        <div class="add-others-cell add-others-body-cell add-others-cell-title">
                          <input type="text" class="add-others-input add-others-title" v-model="other.title">
                        </div>
                        <div class="add-others-cell add-others-body-cell add-others-cell-impression">
                          <textarea class="add-others-input add-others-impression" placeholder="どうだった？" v-model="other.impression"></textarea>
                        </div>
                      </div>
                    </template>
                  </draggable>
                </div>
              </div>

              <!-- 表<小さい用> -->
              <draggable v-model="registerForm.otherList" group="otherList" item-key="key" tag="section" class="add-others-box-small">
                <!-- 1セット -->
                <template #item="{element: other, index: index}">
                  <div class="add-others-bodyblock">
                    <div class="add-others-small-header">
                      {{ index + 1 }}.
                    </div>

                    <!-- 中身 -->
                    <div class="add-others-bodyline">
                      <div class="add-others-small-set">
                        <div class="add-others-cell add-others-header-cell add-others-cell-title">
                          題目
                        </div>
                        <div class="add-others-cell add-others-body-cell add-others-cell-title">
                          <input type="text" class="add-others-input add-others-title" v-model="other.title">
                        </div>
                      </div>
                      
                      <div class="add-others-small-set add-others-impression-cell">
                        <div class="add-others-cell add-others-header-cell add-others-cell-impression">
                          感想
                        </div>
                        <div class="add-others-cell add-others-body-cell add-others-cell-impression">
                          <textarea class="add-others-input add-others-impression" placeholder="どうだった？" v-model="other.impression"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </template>
              </draggable>

              <!-- フォームボタン -->
              <div class="add-add-minus-button-area">
                <div ref="add_minus_button_area_others_form" class="add-minus-button-area" style="visibility: hidden">
                  <button type="button" class="add-add-button" @click="minusOtherForm">
                    <div class="add-add-button-icon">
                      <i class="fa-solid fa-minus"></i>
                    </div>
                  </button>
                </div>
                <div ref="add_add_button_area_others_form" class="add-add-button-area">
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

            <div class="add-photos-button-block">
              <!-- 中身 -->
              <div class="add-photos-area">
                <draggable v-model="registerForm.photoList" group="photoList" item-key="key" tag="section" class="add-photos-block">
                  <!-- 1セット -->
                  <template #item="{element : photo, index: index}">
                    <div class="add-photo-block">
                      <label :for='"add_photo_" + index' class="add-photo-button">選択</label>
                      <input type="file" :id='"add_photo_" + index' class="add-photo" @change="previewFile(index, $event)">
                      <div class="add-photo-preview-area">
                        <output v-if="photo.preview" class="add-photo-output">
                          <button type="button" class="add-photo-resetbutton" @click="resetPhoto(index)"><i class="fa-solid fa-xmark"></i></button>
                          <img :src="photo.preview" alt="" class="add-photo-preview" >
                        </output>
                        
                        <div v-if="errors.photos[index]" class="add-error-message-photo">{{ errors.photos[index] }}</div>
                      </div>
                    </div>
                  </template>
                </draggable>
              </div>

              <!-- フォームボタン -->
              <div class="add-add-minus-button-area">
                <div ref="add_minus_button_area_photos_form" class="add-minus-button-area" style="visibility: hidden">
                  <button type="button" class="add-add-button" @click="minusPhotoForm">
                    <div class="add-add-button-icon">
                      <i class="fa-solid fa-minus"></i>
                    </div>
                  </button>
                </div>
                <div ref="add_add_button_area_photos_form" class="add-add-button-area">
                  <button type="button" class="add-add-button" @click="plusPhotoForm">
                    <div class="add-add-button-icon">
                      <i class="fa-solid fa-plus"></i>
                    </div>
                  </button>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="add-block-2">
          <div class="add-special-area">
            <div class="add-special-area">
              <label for="add_format_DVD" class="add-special-header add-official-header">
                DVD
              </label>
              <input id="add_format_DVD" type="radio" v-model="registerForm.format" value=1 class="add-special-input add-special" checked>
            </div>

            <div class="add-special-area">
              <label for="add_format_Blu" class="add-special-header add-official-header">
                Blu-ray
              </label>
              <input id="add_format_Blu" type="radio" v-model="registerForm.format" value=2 class="add-special-input add-special">
            </div>
          </div>
          <div class="add-special-area">
            <label for="add_official" class="add-special-header add-official-header">
              公式
            </label>
            <input id="add_official" type="checkbox" v-model="registerForm.official" class="add-special-input add-special" checked>
          </div>

          <div class="add-special-area">
            <label for="add_special" class="add-special-header">
              特典
            </label>
            <input id="add_special" type="checkbox" v-model="registerForm.special" class="add-special-input add-special">
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
                <input type="text" v-model="registerForm.url_DVD" class="add-special-input add-special-input-text add-url-DVD">
              </div>

              <div class="add-url-DVD-movie-block add-url-movie-area">
                <div class="add-url-DVD-movie-header add-url-movie-header">
                  ゲキ×シネ
                </div>
                <input type="text" v-model="registerForm.url_movie" class="add-special-input add-special-input-text add-url-movie">
              </div>

              <div class="add-url-DVD-movie-block add-url-movie-area">
                <div class="add-url-DVD-movie-header add-url-movie-header">
                  映像
                </div>
                <input type="text" v-model="registerForm.url_youtube" class="add-special-input add-special-input-text add-url-movie">
              </div>
            </div>
          </div>

          <div class="add-special-area">
            <div class="add-special-header add-category-header">
              カテゴリー
            </div>
            <select class="add-special-input add-special-input-text add-category" v-model="registerForm.category">
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
            送信
          </div>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
  import draggable from 'vuedraggable'
  import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util';
  // ふりがな
  import * as AutoKana from 'vanilla-autokana';

  let autokana;

  export default {
    components: {
        draggable
    },
    data() {
      return{
        registerForm: {
          title: null,
          kana: null,
          durationFrom: '2023-01-01',
          durationTo: '2023-04-01',
          locationList : [{prefecture: null, theater: null}],
          impression: '',
          story: '',
          author: '',
          costumerList: [{name: null}],
          lyricist: '',
          choreo: '',
          director: '',
          playerList : [{key: null, order:0, group_key: '', role: null, player: null, member: false}],
          groupList : [{key: null, order: 0, name: null}],
          roleImpressionList: [{order: 0, role_key: '', impression: null, photoList:[{preview: null, photo: null}] }],
          historyList: [{title: null, history: null}],
          songList: [{title: null, singers: [{type: 'role', role_key: '', group_key: '', name: null}], impression: null}],
          otherList: [{title: null, impression: null}],
          photoList: [{preview: null, photo: ''}],
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
          roleImpressions: [
            {photos: [null]}
          ],
          photos: [null],
          error: null,
        },
        
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
    mounted() {
      for(let i = 0; i < 2; i++){
        this.plusLocationForm();
      }

      // ふりがなのinput要素のidは省略可能
      autokana = AutoKana.bind('#add_title');

      // keyにランダム文字列を代入
      this.registerForm.playerList[0].key = this.getUniqueStr();
      this.registerForm.groupList[0].key = this.getUniqueStr();
    },
    methods: {
      // ランダム文字列作成
      getUniqueStr(){
        const strong = 1000;
        return new Date().getTime().toString(16)  + Math.floor(strong*Math.random()).toString(16)
      },

      // タイトルかな
      getTitle() {
         this.registerForm.kana = autokana.getFurigana();
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

          if(index < this.registerForm.playerList.length){
            this.registerForm.playerList[index].player = player;
            this.registerForm.playerList[index].member = member;
          } else {
            this.registerForm.playerList.push({
              key: this.getUniqueStr(), order: "", group_key: "", role: null, player: player, member: member
            });
          }

          this.playerFlag = true;
          this.plusPlayerForm();
        })
      },

      // 入力された分類名をプルダウンメニューに追加
      getGroup(key) {
        const optionGroup = this.optionGroups.find(group => group.key === key);
        const group = this.registerForm.groupList.find(group => group.key === key);

        if(!optionGroup && group.name) {
          if(group.name.replace(/\s+/g,"")) {
            const newGroupOption = {key: key, order: group.order, name: group.name.replace(/\s+/g,"")};
            this.optionGroups.push(newGroupOption);
            if(this.optionGroups.length - 1 !== this.registerForm.groupList.length) {
              this.optionGroups.sort((a, b) => a.order - b.order);
            }
          }
        } else if(optionGroup) {
          if(!group.name.replace(/\s+/g,"")) {
            this.optionGroups.some((group, index) => {
              if (group.key === optionGroup.key) {
                this.optionGroups.splice(index, 1);
              }
            });
          } else {
            optionGroup.name = group.name.replace(/\s+/g,"");
          }
        }
      },

      // 入力された役名をプルダウンメニューに追加
      getRole(key) {
        const optionRole = this.optionRoles.find(role => role.key === key);
        const player = this.registerForm.playerList.find(role => role.key === key);

        if(!optionRole && player.role) {
          if(player.role.replace(/\s+/g,"")) {
            const newRoleOption = {key: key, order: player.order, role: player.role.replace(/\s+/g,"")};
            this.optionRoles.push(newRoleOption);
            if(this.optionRoles.length - 1 !== this.registerForm.playerList.length) {
              this.optionRoles.sort((a, b) => a.order - b.order);
            }
          }
        } else if(optionRole) {
          if(!player.role.replace(/\s+/g,"")) {
            this.optionRoles.some((role, index) => {
              if (role.key === optionRole.key) {
                this.optionRoles.splice(index, 1);
              }
            });
          } else {
            optionRole.role = player.role.replace(/\s+/g,"");
          }
        }
      },

      // 写真プレビュー
      previewFileRoleImpression(roleImpressionIndex, photoIndex, event) {
        this.errors.roleImpressions[roleImpressionIndex].photos[photoIndex] = null;
        // 何も選択されていなかったら処理中断
        if (event.target.files.length === 0) {
          this.resetPhotoRoleImpression(roleImpressionIndex, photoIndex);
          return false;
        }

        // ファイルが画像ではなかったら処理中断
        if (!event.target.files[0].type.match('image.*')) {
          this.resetPhotoRoleImpression(roleImpressionIndex, photoIndex);
          this.errors.roleImpressions[roleImpressionIndex].photos[photoIndex] = '写真データを選択してください';
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
          this.registerForm.roleImpressionList[roleImpressionIndex].photoList[photoIndex].preview = e.target.result;
        }

        // ファイルを読み込む
        // 読み込まれたファイルはデータURL形式で受け取れる（上記onload参照）
        reader.readAsDataURL(event.target.files[0]);
    
        this.registerForm.roleImpressionList[roleImpressionIndex].photoList[photoIndex].photo = event.target.files[0];
      },

      // 画像をクリアするメソッド
      resetPhotoRoleImpression(roleImpressionIndex, photoIndex) {
        this.registerForm.roleImpressionList[roleImpressionIndex].photoList[photoIndex].preview = null;
        this.registerForm.roleImpressionList[roleImpressionIndex].photoList[photoIndex].photo = null;
        document.getElementById('add_role_impressions_photo_large_' + roleImpressionIndex + '_' + photoIndex).value = null;
        document.getElementById('add_role_impressions_photo_small_' + roleImpressionIndex + '_' + photoIndex).value = null;
      },

      // 写真プレビュー
      previewFile(index, event) {
        this.errors.photos[index] = null;
        // 何も選択されていなかったら処理中断
        if (event.target.files.length === 0) {
          this.resetPhoto(index);
          return false;
        }

        // ファイルが画像ではなかったら処理中断
        if (!event.target.files[0].type.match('image.*')) {
          this.resetPhoto(index);
          this.errors.photos[index] = '写真データを選択してください';
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
          this.registerForm.photoList[index].preview = e.target.result;
        }

        // ファイルを読み込む
        // 読み込まれたファイルはデータURL形式で受け取れる（上記onload参照）
        reader.readAsDataURL(event.target.files[0]);
    
        this.registerForm.photoList[index].photo = event.target.files[0];
      },

      // 画像をクリアするメソッド
      resetPhoto(index) {
        this.registerForm.photoList[index].preview = null;
        this.registerForm.photoList[index].photo = '';
        document.getElementById('add_photo_' + index).value = null;
      },

      // データ送信
      async regiterData() {
        let patternNumber = /^([0-9]\d*|0)$/; // 0~9の数字かどうか
        let patternAlf = /^([A-Z]\d*)$/; // A~Zのアルファベットかどうか*いる
        let patternKanaHira = /^[ぁ-んァ-ンヴーｧ-ﾝﾞﾟ\-]+$/u;
        const formData = new FormData();
        let kanas;
        let kana = '';
        let roleList;
        let count = 0;
        let count2 = 0;
        
        if(!this.registerForm.title.replace(/\s+/g,'') || !this.registerForm.kana.replace(/\s+/g,'')) {
          return false;
        }

        // タイトル（ふりがな）正規表現
        kanas = [...this.registerForm.kana.replace(/\s+/g,'')];
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
        
        formData.append('title', this.registerForm.title.replace(/\s+/g,''));
        formData.append('kana', kana);
        formData.append('durationFrom', this.registerForm.durationFrom);
        formData.append('durationTo', this.registerForm.durationTo);

        for(let i = 0; i < this.registerForm.locationList.length; i++) {
          const location = this.registerForm.locationList[i];
          if(location.prefecture){
            formData.append('location[' + count + '][order]', count + 1);
            formData.append('location[' + count + '][prefecture]', location.prefecture);
            formData.append('location[' + count + '][theater]', location.theater);
            count++;
          }
        };
        count = 0;

        formData.append('impression', this.registerForm.impression.replace(/\s+/g,'') ? this.registerForm.impression : '');
        formData.append('story', this.registerForm.story.replace(/\s+/g,'') ? this.registerForm.story : '');
        formData.append('author', this.registerForm.author.replace(/\s+/g,'') ? this.registerForm.author.replace(/\s+/g,'') : '');

        for(let i = 0; i < this.registerForm.costumerList.length; i++) {
          const costumer = this.registerForm.costumerList[i];
          if(costumer.name) {
            if(costumer.name.replace(/\s+/g, '')) {
              formData.append('costumer[' + count + '][order]', count + 1);
              formData.append('costumer[' + count + '][name]', costumer.name.replace(/\s+/g, ''));
              count++;
            }
          }
        }
        count = 0;

        formData.append('lyricist', this.registerForm.lyricist.replace(/\s+/g,'') ? this.registerForm.lyricist.replace(/\s+/g,'') : '');
        formData.append('choreo', this.registerForm.choreo.replace(/\s+/g,'') ? this.registerForm.choreo.replace(/\s+/g,'') : '');
        formData.append('directory', this.registerForm.director.replace(/\s+/g,'') ? this.registerForm.director.replace(/\s+/g,'') : '');

        for(let i = 0; i < this.registerForm.groupList.length; i++) {
          const group = this.registerForm.groupList[i];
          if(group.name){
            if(group.name.replace(/\s+/g,'')) {
              formData.append('group[' + count + '][order]', count + 1);
              formData.append('group[' + count + '][key]', group.key);
              formData.append('group[' + count + '][name]', group.name.replace(/\s+/g,''));
              count++;
            }
          }
        };
        count = 0;

        for(let i = 0; i < this.registerForm.playerList.length; i++) {
          const player = this.registerForm.playerList[i];
          if(player.player){
            if(player.player.replace(/\s+/g,'')) {
              const  role_impression = this.registerForm.roleImpressionList.find(roleImpression => roleImpression.role_key === player.key);
              
              formData.append('role[' + count + '][order]', count + 1);
              formData.append('role[' + count + '][group_key]', player.group_key ? player.group_key : '');
              formData.append('role[' + count + '][role]', player.role ? player.role.replace(/\s+/g,'') : '');
              formData.append('role[' + count + '][key]', player.key);
              formData.append('role[' + count + '][player]', player.player.replace(/\s+/g,''));
              formData.append('role[' + count + '][member]', player.member ? 1 : 0);
              formData.append('role[' + count + '][impression]', role_impression ? role_impression.impression.replace(/\s+/g,'') ? role_impression.impression : '' : '');
              if(role_impression.photoList) {
                for(let k = 0; k < role_impression.photoList.length; k++) {
                  const photo = role_impression.photoList[k];
                  if(photo.photo) {
                    formData.append('role[' + count + '][photo][' + count2  + '][order]', count2 + 1);
                    formData.append('role[' + count + '][photo][' + count2  + '][photo]', photo.photo);
                    count2++;
                  }
                }
              }              
              count++;
              count2 = 0;
            }
          }
        };
        count = 0;

        for(let i = 0; i < this.registerForm.historyList.length; i++) {
          const history = this.registerForm.historyList[i];
          if(history.history) {
            if(history.history.replace(/\s+/g, '')) {
              let history_flag = 0;
              if(history.title) {
                if(history.title.replace(/\s+/g, '')) {
                  history_flag = 1;
                } else if(this.registerForm.historyList.length === 1 && history.history) {
                  if(history.history.replace(/\s+/g,'')) {
                    history_flag = 1;
                  }
                }
              } else if(this.registerForm.historyList.length === 1 && history.history) {
                if(history.history.replace(/\s+/g,'')) {
                  history_flag = 1;
                }
              }

              if(history_flag) {
                formData.append('history[' + count + '][order]', count + 1);
                formData.append('history[' + count + '][title]', history.title.replace(/\s+/g, '') ? history.title.replace(/\s+/g,'') : '');
                formData.append('history[' + count + '][history]', history.history.replace(/\s+/g,'') ? history.history : '');
                count++;
              }
            }
          }
        }
        count = 0;
        
        for(let i = 0; i < this.registerForm.songList.length; i++) {
          const song = this.registerForm.songList[i];

          if(song.title){
            if(song.title.replace(/\s+/g,'')) {
              formData.append('song[' + count + '][order]', count + 1);
              formData.append('song[' + count + '][title]', song.title.replace(/\s+/g,''));
              formData.append('song[' + count + '][impression]', song.impression ? song.impression.replace(/\r+/g, '') ? song.impression : '' : '');
              
              if(song.singers.length) {
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
                      formData.append('song[' + count + '][singer][' + count2 + '][order]', count2 + 1);
                      formData.append('song[' + count + '][singer][' + count2 + '][type]', singer.type);
                      if(singer.type === 'role') {
                        formData.append('song[' + count + '][singer][' + count2 + '][name]', singer.role);
                      } else if(singer.type === 'group') {
                        formData.append('song[' + count + '][singer][' + count2 + '][name]', singer.group);
                      } else if(singer.type === 'name') {
                        formData.append('song[' + count + '][singer][' + count2 + '][name]', singer.name.replace(/\s+/g, ''));
                      }                      
                      count2++;
                    }
                  }
                }
              }
              count++;
              count2 = 0;
            }
          }
        };
        count = 0;

        for(let i = 0; i < this.registerForm.otherList.length; i++) {
          const other = this.registerForm.otherList[i];
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
            formData.append('other[' + count + '][order]', count + 1);
            formData.append('other[' + count + '][title]', other_title_flag ? other.title.replace(/\s+/g,'') : '');
            formData.append('other[' + count + '][impression]', other_impression_flag ? other.impression : '');
            count++;
          }
        };
        count = 0;

        for(let i = 0; i < this.registerForm.photoList.length; i++) {
          const photo = this.registerForm.photoList[i];

          if(photo.photo) {
            formData.append('photo[' + count + '][order]', count + 1);
            formData.append('photo[' + count + '][photo]', photo.photo);
            count++;
          }
        }
        count = 0;

        formData.append('format', this.registerForm.format == 1 ? 1 : 2);
        formData.append('official', this.registerForm.official ? 1 : 0);
        formData.append('special', this.registerForm.special ? 1 : 0);
        formData.append('url_DVD', this.registerForm.url_DVD);
        formData.append('url_movie', this.registerForm.url_movie);
        formData.append('url_youtube', this.registerForm.url_youtube);
        formData.append('category', this.registerForm.category);

        const response = await axios.post('/api/DVD', formData);
  
        if (response.status === 422) {
          this.errors.error = response.data.errors;
          // メッセージ登録
          this.$store.commit('message/setContent', {
            content: '登録できませんでした',
            timeout: 6000
          });
          return false;
        }

        if (response.status !== 201) {
          this.$store.commit('error/setCode', response.status);
          // メッセージ登録
          this.$store.commit('message/setContent', {
            content: '登録できませんでした',
            timeout: 6000
          });
          return false;
        }

        // 諸々データ削除
        this.reset();
        
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

      // フォーム削除
      reset() {
        this.registerForm = {
          title: null,
          kana: null,
          durationFrom: '2023-01-01',
          durationTo: '2023-04-01',
          locationList : [{prefecture: null, theater: null}],
          impression: '',
          story: '',
          author: '',
          costumerList: [{name: null}],
          lyricist: '',
          choreo: '',
          director: '',
          playerList : [{key: this.getUniqueStr(), order: 0, group_key: '', role: null, player: null, member: false}],
          groupList : [{key: this.getUniqueStr(), order: 0, name: null}],
          roleImpressionList: [{order: 0, role_key: "", impression: null, photoList:[{preview: null, photo: null}] }],
          historyList: [{title: null, history: null}],
          songList: [{title: null, singers: [{type: 'role', role_key: '', group_key: '', name: null}], impression: null}],
          otherList: [{title: null, impression: null}],
          preview: null,
          photoList: [{preview: null, photo: ''}],
          format: 1,
          official: true,
          special: false,
          url_DVD: '',
          url_movie: '',
          url_youtube: '',
          category: 1
        };
        this.playersAll = null;
        this.playerFlag = false,
        this.optionPlayers = []; // 役者
        this.optionGroups = []; // 分類名
        this.optionRoles = []; // 役名
        // エラー
        this.errors = {
          photo: {
            roleImpression: null,
            pres: null
          },
          photos: [null],
          error: null,
        };

        // 劇場
        for(let i = 0; i < 2; i++){
          this.plusLocationForm();
        }

        // 写真
        let photos = [].slice.call(document.querySelectorAll('[id^="add_photo_"]'));
        photos.forEach(photo => {
          photo.value = null;
        });

        let roleImpressionsPhotosLarge = [].slice.call(document.querySelectorAll('[id^="add_role_impressions_photo_large_"]'));
        roleImpressionsPhotosLarge.forEach(roleImpressionsPhoto => {
          roleImpressionsPhoto.value = null;
        });

        let roleImpressionsPhotosSmall = [].slice.call(document.querySelectorAll('[id^="add_role_impressions_photo_small_"]'));
        roleImpressionsPhotosSmall.forEach(roleImpressionsPhoto => {
          roleImpressionsPhoto.value = null;
        });
      },

      // フォーム関係
      // 劇場フォーム
      plusLocationForm() {
        if(this.registerForm.locationList.length < 10) {
          // 追加
          this.registerForm.locationList.push({
            prefecture: null, theater: null
          });

          if(this.registerForm.locationList.length === 2) {
            this.$refs.add_minus_button_area_locations_form.style.visibility = 'visible';
          } else if (this.registerForm.locationList.length === 10) {
            this.$refs.add_add_button_area_locations_form.style.visibility = 'hidden';
          }
        }
      },
      minusLocationForm() {
        if(this.registerForm.locationList.length > 1) {
          // 削除
          this.registerForm.locationList.pop();

          if(this.registerForm.locationList.length === 1){
            this.$refs.add_minus_button_area_locations_form.style.visibility = 'hidden';
          } else if (this.registerForm.locationList.length === 9) {
            this.$refs.add_add_button_area_locations_form.style.visibility = 'visible';
          }
        }
      },

       // 衣装フォーム
       plusCostumerForm() {
        if(this.registerForm.costumerList.length < 5) {
          // 追加
          this.registerForm.costumerList.push({
            name: null
          });

          if(this.registerForm.costumerList.length === 2) {
            this.$refs.add_minus_button_area_costumers_form.style.visibility = 'visible';
          } else if (this.registerForm.costumerList.length === 5) {
            this.$refs.add_add_button_area_costumers_form.style.visibility = 'hidden';
          }
        }
      },
      minusCostumerForm() {
        if(this.registerForm.costumerList.length > 1) {
          // 削除
          this.registerForm.costumerList.pop();

          if(this.registerForm.costumerList.length === 1){
            this.$refs.add_minus_button_area_costumers_form.style.visibility = 'hidden';
          } else if (this.registerForm.costumerList.length === 4) {
            this.$refs.add_add_button_area_costumers_form.style.visibility = 'visible';
          }
        }
      },

      // 出演者フォーム
      plusPlayerForm() {
        if(this.registerForm.playerList.length < 50) {
          // 追加
          if(!this.playerFlag){
            this.registerForm.playerList.push({
              key: this.getUniqueStr(), order:this.registerForm.playerList.length, group_key: '', role: null, player: null, member: false
            });
          }
          this.playerFlag = false;

          if(this.registerForm.playerList.length === 2) {
            this.$refs.add_minus_button_area_players_form.style.visibility = 'visible';
          } else if (this.registerForm.playerList.length === 50) {
            this.$refs.add_add_button_area_players_form.style.visibility = 'hidden';
          }

          if(this.registerForm.groupList.length < this.registerForm.playerList.length && this.registerForm.groupList.length < 5) {
            this.$refs.add_add_button_area_groups_form.style.visibility = 'visible';
          }

          if(this.registerForm.roleImpressionList.length < this.registerForm.playerList.length && this.registerForm.roleImpressionList.length < 50) {
            this.$refs.add_add_button_area_role_impressions_form.style.visibility = 'visible';
          }
        }
      },
      minusPlayerForm() {
        if(this.registerForm.playerList.length > 1) {
          // 削除
          const popPlayer = this.registerForm.playerList.pop();
          if(popPlayer.role) {
            const popRole = this.optionRoles.pop();
            this.registerForm.roleImpressionList.forEach(roleImpression => {
              if(roleImpression.role_key === popRole.key) {
                roleImpression.role_key = "";
              }
            });
          }

          if(this.registerForm.playerList.length === 1){
            this.$refs.add_minus_button_area_players_form.style.visibility = 'hidden';
          } else if (this.registerForm.playerList.length === 49) {
            this.$refs.add_add_button_area_players_form.style.visibility = 'visible';
          }

          if(this.registerForm.groupList.length > this.registerForm.playerList.length) {
            this.minusGroupForm();
            this.$refs.add_add_button_area_groups_form.style.visibility = 'hidden';
          } else if(this.registerForm.groupList.length === this.registerForm.playerList.length) {
            this.$refs.add_add_button_area_groups_form.style.visibility = 'hidden';
          }

          if(this.registerForm.roleImpressionList.length > this.registerForm.playerList.length) {
            this.minusRoleImpressionForm();
            this.$refs.add_add_button_area_role_impressions_form.style.visibility = 'hidden';
          } else if(this.registerForm.roleImpressionList.length === this.registerForm.playerList.length) {
            this.$refs.add_add_button_area_role_impressions_form.style.visibility = 'hidden';
          }
        }
      },
      // 移動したら
      endMovePlayer() {
        this.registerForm.playerList.forEach((player, index) => {
          player.order = index;
          const optionRoleIndex = this.optionRoles.findIndex(optionRole => optionRole.key === player.key);
          const roleImpressionIndex = this.registerForm.roleImpressionList.findIndex(roleImpression => roleImpression.role_key === player.key);
          if(optionRoleIndex > -1) {
            this.optionRoles[optionRoleIndex].order = index;
          }

          if(roleImpressionIndex > -1) {
            this.registerForm.roleImpressionList[roleImpressionIndex].order = index;
          }
        });

        this.optionRoles.sort(function(a, b) {
          return a.order - b.order;
        });
        this.registerForm.roleImpressionList.sort(function(a, b) {
          return a.order - b.order;
        });
      },

      // 分類フォーム
      plusGroupForm() {
        if(this.registerForm.groupList.length < 10) {
          // 追加
          this.registerForm.groupList.push({
            key: this.getUniqueStr(), order: this.registerForm.groupList.length, name: null
          });

          if(this.registerForm.groupList.length === 2){
            this.$refs.add_minus_button_area_groups_form.style.visibility = 'visible';
          } else if(this.registerForm.groupList.length === 10) {
            this.$refs.add_add_button_area_groups_form.style.visibility = 'hidden';
          } 
          
          if(this.registerForm.groupList.length >= this.registerForm.playerList.length || this.registerForm.groupList.length === 10) {
            this.$refs.add_add_button_area_groups_form.style.visibility = 'hidden';
          } else if (this.registerForm.groupList.length < 10 && this.registerForm.groupList.length < this.registerForm.playerList.length) {
            this.$refs.add_add_button_area_groups_form.style.visibility = 'visible';
          }
        }
      },
      minusGroupForm() {
        if(this.registerForm.groupList.length > 1) {
          // 削除
          const popGroup = this.registerForm.groupList.pop();
          if(popGroup.name) {
            this.optionGroups.pop();
            this.registerForm.playerList.forEach(player => {
              if(player.group_key === popGroup.key) {
                player.group_key = "";
              }
            });
          }

          if(this.registerForm.groupList.length === 1){
            this.$refs.add_minus_button_area_groups_form.style.visibility = 'hidden';
          } else if(this.registerForm.groupList.length === 9) {
            this.$refs.add_add_button_area_groups_form.style.visibility = 'visible';
          }
          
          if(this.registerForm.groupList.length >= this.registerForm.playerList.length || this.registerForm.groupList.length === 10) {
            this.$refs.add_add_button_area_groups_form.style.visibility = 'hidden';
          } else if (this.registerForm.groupList.length < 10 && this.registerForm.groupList.length < this.registerForm.playerList.length) {
            this.$refs.add_add_button_area_groups_form.style.visibility = 'visible';
          }
        }
      },
      // 動かしたら
      endMoveGroup() {
        this.registerForm.groupList.forEach((group, index) => {
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
        if(this.registerForm.roleImpressionList.length < 50 && this.registerForm.roleImpressionList.length < this.registerForm.playerList.length) {
          // 追加
          this.registerForm.roleImpressionList.push({
            order: null, role_key: "", impression: null, photoList: [{preview: null, photo: null}]
          });
          this.errors.roleImpressions.push({photos: [null]});

          if(this.registerForm.roleImpressionList.length === 2){
            this.$refs.add_minus_button_area_role_impressions_form.style.visibility = 'visible';
          } else if(this.registerForm.roleImpressionList.length === 50) {
            this.$refs.add_add_button_area_role_impressions_form.style.visibility = 'hidden';
          } 
          
          if(this.registerForm.roleImpressionList.length >= this.registerForm.playerList.length || this.registerForm.roleImpressionList.length === 50) {
            this.$refs.add_add_button_area_role_impressions_form.style.visibility = 'hidden';
          } else if (this.registerForm.roleImpressionList.length < 50 && this.registerForm.roleImpressionList.length < this.registerForm.playerList.length) {
            this.$refs.add_add_button_area_role_impressions_form.style.visibility = 'visible';
          }
        }
      },
      minusRoleImpressionForm() {
        if(this.registerForm.roleImpressionList.length > 1) {
          // 削除
          this.registerForm.roleImpressionList.pop();
          this.errors.roleImpressions.pop();

          if(this.registerForm.roleImpressionList.length === 1){
            this.$refs.add_minus_button_area_role_impressions_form.style.visibility = 'hidden';
          } else if(this.registerForm.roleImpressionList.length === 49) {
            this.$refs.add_add_button_area_role_impressions_form.style.visibility = 'visible';
          } 

          if(this.registerForm.roleImpressionList.length >= this.registerForm.playerList.length || this.registerForm.roleImpressionList.length === 50) {
            this.$refs.add_add_button_area_role_impressions_form.style.visibility = 'hidden';
          } else if (this.registerForm.roleImpressionList.length < 50 && this.registerForm.roleImpressionList.length < this.registerForm.playerList.length) {
            this.$refs.add_add_button_area_role_impressions_form.style.visibility = 'visible';
          }
        }
      },
      // 役を選んだら
      chooseRole(index) {
        const key = this.registerForm.roleImpressionList[index].role_key;
        const chosePlayer = this.registerForm.playerList.find(player => player.key === key);
        this.registerForm.roleImpressionList[index].order = chosePlayer.order;
      },

      // 役感想_写真フォーム
      plusRoleImpressionPhotoForm(roleImpressionIndex) {
        if(this.registerForm.roleImpressionList[roleImpressionIndex].photoList.length < 5) {
          // 追加
          this.registerForm.roleImpressionList[roleImpressionIndex].photoList.push({
            preview: null, photo: null
          });
          this.errors.roleImpressions[roleImpressionIndex].photos.push(null);          

          if(this.registerForm.roleImpressionList[roleImpressionIndex].photoList.length === 2) {
            this.$refs.add_minus_button_area_role_impression_photos_form_large[roleImpressionIndex].style.visibility = 'visible';
            this.$refs.add_minus_button_area_role_impression_photos_form_small[roleImpressionIndex].style.visibility = 'visible';
          } else if (this.registerForm.roleImpressionList[roleImpressionIndex].photoList.length === 5) {
            this.$refs.add_add_button_area_role_impression_photos_form_large[roleImpressionIndex].style.visibility = 'hidden';
            this.$refs.add_add_button_area_role_impression_photos_form_small[roleImpressionIndex].style.visibility = 'hidden';
          }
        }
      },
      minusRoleImpressionPhotoForm(roleImpressionIndex) {
        if(this.registerForm.roleImpressionList[roleImpressionIndex].photoList.length > 1) {
          // 削除
          this.registerForm.roleImpressionList[roleImpressionIndex].photoList.pop();
          this.errors.roleImpressions[roleImpressionIndex].photos.pop();

          if(this.registerForm.roleImpressionList[roleImpressionIndex].photoList.length === 1){
            this.$refs.add_minus_button_area_role_impression_photos_form_large[roleImpressionIndex].style.visibility = 'hidden';
            this.$refs.add_minus_button_area_role_impression_photos_form_small[roleImpressionIndex].style.visibility = 'hidden';
          } else if (this.registerForm.roleImpressionList[roleImpressionIndex].photoList.length === 4) {
            this.$refs.add_add_button_area_role_impression_photos_form_large[roleImpressionIndex].style.visibility = 'visible';
            this.$refs.add_add_button_area_role_impression_photos_form_small[roleImpressionIndex].style.visibility = 'visible';
          }
        }
      },

      // 歴史フォーム
      plusHistoryForm() {
        if(this.registerForm.historyList.length < 10) {
          // 追加
          this.registerForm.historyList.push({
            title: null, history: null
          });

          if(this.registerForm.historyList.length === 2) {
            this.$refs.add_minus_button_area_histories_form.style.visibility = 'visible';
          } else if (this.registerForm.historyList.length === 10) {
            this.$refs.add_add_button_area_histories_form.style.visibility = 'hidden';
          }
        }
      },
      minusHistoryForm() {
        if(this.registerForm.historyList.length > 1) {
          // 削除
          this.registerForm.historyList.pop();

          if(this.registerForm.historyList.length === 1){
            this.$refs.add_minus_button_area_histories_form.style.visibility = 'hidden';
          } else if (this.registerForm.historyList.length === 9) {
            this.$refs.add_add_button_area_histories_form.style.visibility = 'visible';
          }
        }
      },

      // 歌フォーム
      plusSongForm() {
        if(this.registerForm.songList.length < 10) {
          // 追加
          this.registerForm.songList.push({
            title: null, singers:[{type: 'role', role_key: '', group_key: '', name: null}], impression: null
          });

          if(this.registerForm.songList.length === 2) {
            this.$refs.add_minus_button_area_songs_form.style.visibility = 'visible';
          } else if (this.registerForm.songList.length === 10) {
            this.$refs.add_add_button_area_songs_form.style.visibility = 'hidden';
          }
        }
      },
      minusSongForm() {
        if(this.registerForm.songList.length > 1) {
          // 削除
          this.registerForm.songList.pop();

          if(this.registerForm.songList.length === 1){
            this.$refs.add_minus_button_area_songs_form.style.visibility = 'hidden';
          } else if (this.registerForm.songList.length === 9) {
            this.$refs.add_add_button_area_songs_form.style.visibility = 'visible';
          }
        }
      },
      endMoveSong() {
        this.registerForm.songList.forEach((song, index) => {
          const addButton = 'add_add_button_area_singers_form_' + index;
          const minusButton = 'add_minus_button_area_singers_form_' + index;
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
        if(this.registerForm.songList[songIndex].singers.length < 10) {
          // 追加
          this.registerForm.songList[songIndex].singers.push({
            type: 'role', role_key: '', group_key: '', name: null
          });

          const addButton = 'add_add_button_area_singers_form_' + songIndex;
          const minusButton = 'add_minus_button_area_singers_form_' + songIndex;

          if(this.registerForm.songList[songIndex].singers.length === 2) {
            this.$refs[minusButton].style.visibility = 'visible';
          } else if (this.registerForm.songList[songIndex].singers.length === 10) {
            this.$refs[addButton].style.visibility = 'hidden';
          }
        }
      },
      minusSingerForm(songIndex) {
        if(this.registerForm.songList[songIndex].singers.length > 1) {
          // 削除
          this.registerForm.songList[songIndex].singers.pop();
          
          const addButton = 'add_add_button_area_singers_form_' + songIndex;
          const minusButton = 'add_minus_button_area_singers_form_' + songIndex;

          if(this.registerForm.songList[songIndex].singers.length === 1){
            this.$refs[minusButton].style.visibility = 'hidden';
          } else if (this.registerForm.songList[songIndex].singers.length === 9) {
            this.$refs[addButton].style.visibility = 'visible';
          }
        }
      },

      // その他フォーム
      plusOtherForm() {
        if(this.registerForm.otherList.length < 10) {
          // 追加
          this.registerForm.otherList.push({
            title: null, impression: null
          });

          if(this.registerForm.otherList.length === 2) {
            this.$refs.add_minus_button_area_others_form.style.visibility = 'visible';
          } else if (this.registerForm.otherList.length === 10) {
            this.$refs.add_add_button_area_others_form.style.visibility = 'hidden';
          }
        }
      },
      minusOtherForm() {
        if(this.registerForm.otherList.length > 1) {
          // 削除
          this.registerForm.otherList.pop();

          if(this.registerForm.otherList.length === 1){
            this.$refs.add_minus_button_area_others_form.style.visibility = 'hidden';
          } else if (this.registerForm.otherList.length === 9) {
            this.$refs.add_add_button_area_others_form.style.visibility = 'visible';
          }
        }
      },

      // 写真フォーム
      plusPhotoForm() {
        if(this.registerForm.photoList.length < 10) {
          // 追加
          this.registerForm.photoList.push({
            preview: null, photo: ''
          });
          this.errors.photos.push(null);

          if(this.registerForm.photoList.length === 2) {
            this.$refs.add_minus_button_area_photos_form.style.visibility = 'visible';
          } else if (this.registerForm.photoList.length === 10) {
            this.$refs.add_add_button_area_photos_form.style.visibility = 'hidden';
          }
        }
      },
      minusPhotoForm() {
        if(this.registerForm.photoList.length > 1) {
          // 削除
          this.registerForm.photoList.pop();
          this.errors.photos.pop();

          if(this.registerForm.photoList.length === 1){
            this.$refs.add_minus_button_area_photos_form.style.visibility = 'hidden';
          } else if (this.registerForm.photoList.length === 9) {
            this.$refs.add_add_button_area_photos_form.style.visibility = 'visible';
          }
        }
      }
    }
  }  
</script>