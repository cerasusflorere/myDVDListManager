<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
    <link rel="icon" href="iconStar.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" rel="stylesheet">
    <title>新規追加</title>
</head>
<?php
    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN'); 
?>

<body>    
    <main class='add'>
        <div class='add-block'>
            <div class='add-block-1'>
                <!-- タイトル -->
                <div class='add-area add-title-area'>
                    <div class='add-header'>
                        タイトル
                    </div>
                    <div class='add-title-kana-area'>
                        <input type='text' id='add_title' class='add-title' placeholder="タイトル" onkeyup='getTitleKana()'>
                        <input type='text' id='add_title_kana' class='add-title add-title-kana' placeholder="たいとる">
                    </div>
                    
                </div>

                <!-- 公演期間 -->
                <div class='add-area add-duration-area'>
                    <div class='add-header'>
                        公演期間
                    </div>
                    <div class='add-duration-input-area'>
                        <input type="date" value="2023-01-04" id='add_duration_from' class='add-duration'> 
                        <div class='add-duration-conection'>
                            ~
                        </div>
                        <input type="date" value="2023-01-12" id='add_duration_to' class='add-duration'> 
                    </div>
                </div>

                <!-- 公演場所 -->
                <div class='add-area add-location-area'>
                    <div class='add-header'>
                        公演場所
                    </div>
                    
                    <div class='add-locations-button-area'>
                        <div id='add_locations_block' class='add-locations'>
                            <!-- 1セット -->
                            <div id='add_location_1' class='add-location'>
                                <select id='add_location_prefecture_1' class='add-location-prefecture'>
                                    <option hidden>選択</option>
                                    <option value="1">北海道</option>
                                    <option value="2">青森県</option>
                                    <option value="3">岩手県</option>
                                    <option value="4">宮城県</option>
                                    <option value="5">秋田県</option>
                                    <option value="6">山形県</option>
                                    <option value="7">福島県</option>
                                    <option value="8">茨城県</option>
                                    <option value="9">栃木県</option>
                                    <option value="10">群馬県</option>
                                    <option value="11">埼玉県</option>
                                    <option value="12">千葉県</option>
                                    <option value="13">東京都</option>
                                    <option value="14">神奈川県</option>
                                    <option value="15">新潟県</option>
                                    <option value="16">富山県</option>
                                    <option value="17">石川県</option>
                                    <option value="18">福井県</option>
                                    <option value="19">山梨県</option>
                                    <option value="20">長野県</option>
                                    <option value="21">岐阜県</option>
                                    <option value="22">静岡県</option>
                                    <option value="23">愛知県</option>
                                    <option value="24">三重県</option>
                                    <option value="25">滋賀県</option>
                                    <option value="26">京都府</option>
                                    <option value="27">大阪府</option>
                                    <option value="28">兵庫県</option>
                                    <option value="29">奈良県</option>
                                    <option value="30">和歌山県</option>
                                    <option value="31">鳥取県</option>
                                    <option value="32">島根県</option>
                                    <option value="33">岡山県</option>
                                    <option value="34">広島県</option>
                                    <option value="35">山口県</option>
                                    <option value="36">徳島県</option>
                                    <option value="37">香川県</option>
                                    <option value="38">愛媛県</option>
                                    <option value="39">高知県</option>
                                    <option value="40">福岡県</option>
                                    <option value="41">佐賀県</option>
                                    <option value="42">長崎県</option>
                                    <option value="43">熊本県</option>
                                    <option value="44">大分県</option>
                                    <option value="45">宮崎県</option>
                                    <option value="46">鹿児島県</option>
                                    <option value="47">沖縄県</option>
                                </select>

                                <input type='text' id='add_location_theater_1' class='add-location-theater'>
                            </div>

                            <!-- 2セット -->
                            <div id='add_location_2' class='add-location'>
                                <select id='add_location_prefecture_2' class='add-location-prefecture'>
                                    <option hidden>選択</option>
                                    <option value="1">北海道</option>
                                    <option value="2">青森県</option>
                                    <option value="3">岩手県</option>
                                    <option value="4">宮城県</option>
                                    <option value="5">秋田県</option>
                                    <option value="6">山形県</option>
                                    <option value="7">福島県</option>
                                    <option value="8">茨城県</option>
                                    <option value="9">栃木県</option>
                                    <option value="10">群馬県</option>
                                    <option value="11">埼玉県</option>
                                    <option value="12">千葉県</option>
                                    <option value="13">東京都</option>
                                    <option value="14">神奈川県</option>
                                    <option value="15">新潟県</option>
                                    <option value="16">富山県</option>
                                    <option value="17">石川県</option>
                                    <option value="18">福井県</option>
                                    <option value="19">山梨県</option>
                                    <option value="20">長野県</option>
                                    <option value="21">岐阜県</option>
                                    <option value="22">静岡県</option>
                                    <option value="23">愛知県</option>
                                    <option value="24">三重県</option>
                                    <option value="25">滋賀県</option>
                                    <option value="26">京都府</option>
                                    <option value="27">大阪府</option>
                                    <option value="28">兵庫県</option>
                                    <option value="29">奈良県</option>
                                    <option value="30">和歌山県</option>
                                    <option value="31">鳥取県</option>
                                    <option value="32">島根県</option>
                                    <option value="33">岡山県</option>
                                    <option value="34">広島県</option>
                                    <option value="35">山口県</option>
                                    <option value="36">徳島県</option>
                                    <option value="37">香川県</option>
                                    <option value="38">愛媛県</option>
                                    <option value="39">高知県</option>
                                    <option value="40">福岡県</option>
                                    <option value="41">佐賀県</option>
                                    <option value="42">長崎県</option>
                                    <option value="43">熊本県</option>
                                    <option value="44">大分県</option>
                                    <option value="45">宮崎県</option>
                                    <option value="46">鹿児島県</option>
                                    <option value="47">沖縄県</option>
                                </select>

                                <input type='text' id='add_location_theater_2' class='add-location-theater'>
                            </div>

                            <!-- 3セット -->
                            <div id='add_location_3' class='add-location'>
                                <select id='add_location_prefecture_3' class='add-location-prefecture'>
                                    <option hidden>選択</option>
                                    <option value="1">北海道</option>
                                    <option value="2">青森県</option>
                                    <option value="3">岩手県</option>
                                    <option value="4">宮城県</option>
                                    <option value="5">秋田県</option>
                                    <option value="6">山形県</option>
                                    <option value="7">福島県</option>
                                    <option value="8">茨城県</option>
                                    <option value="9">栃木県</option>
                                    <option value="10">群馬県</option>
                                    <option value="11">埼玉県</option>
                                    <option value="12">千葉県</option>
                                    <option value="13">東京都</option>
                                    <option value="14">神奈川県</option>
                                    <option value="15">新潟県</option>
                                    <option value="16">富山県</option>
                                    <option value="17">石川県</option>
                                    <option value="18">福井県</option>
                                    <option value="19">山梨県</option>
                                    <option value="20">長野県</option>
                                    <option value="21">岐阜県</option>
                                    <option value="22">静岡県</option>
                                    <option value="23">愛知県</option>
                                    <option value="24">三重県</option>
                                    <option value="25">滋賀県</option>
                                    <option value="26">京都府</option>
                                    <option value="27">大阪府</option>
                                    <option value="28">兵庫県</option>
                                    <option value="29">奈良県</option>
                                    <option value="30">和歌山県</option>
                                    <option value="31">鳥取県</option>
                                    <option value="32">島根県</option>
                                    <option value="33">岡山県</option>
                                    <option value="34">広島県</option>
                                    <option value="35">山口県</option>
                                    <option value="36">徳島県</option>
                                    <option value="37">香川県</option>
                                    <option value="38">愛媛県</option>
                                    <option value="39">高知県</option>
                                    <option value="40">福岡県</option>
                                    <option value="41">佐賀県</option>
                                    <option value="42">長崎県</option>
                                    <option value="43">熊本県</option>
                                    <option value="44">大分県</option>
                                    <option value="45">宮崎県</option>
                                    <option value="46">鹿児島県</option>
                                    <option value="47">沖縄県</option>
                                </select>

                                <input type='text' id='add_location_theater_3' class='add-location-theater'>
                            </div>
                        </div>

                        <!-- フォームボタン -->
                        <div class='add-add-minus-button-area'>
                            <div id='add_minus_button_area_locations_form' class='add-minus-button-area'>
                                <button class='add-add-button' onclick="minusLocationForm()">
                                    <div class='add-add-button-icon'>
                                        <i class="fa-solid fa-minus"></i>
                                    </div>
                                </button>
                            </div>
                            <div id='add_add_button_area_locations_form' class='add-add-button-area'>
                                <button class='add-add-button' onclick="plusLocationForm()">
                                    <div class='add-add-button-icon'>
                                        <i class='fa-solid fa-plus'></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <!-- 感想 -->
                <div class='add-area add-impression-area'>
                    <div class='add-header'>
                        感想
                    </div>
                    <textarea id='add_impression' class='add-impression' placeholder="どうだった？"></textarea>
                </div>

                <!-- あらすじ -->
                <div class='add-area add-story-area'>
                    <div class='add-header'>
                        あらすじ
                    </div>
                    <textarea id='add_story' class='add-story' placeholder="あらすじ"></textarea>
                </div>

                <!-- 脚本 -->
                <div class='add-area add-author-area'>
                    <div class='add-header'>
                        作
                    </div>
                    <input type='text' id='add_author' class='add-author'>
                </div>
                
                <!-- 出演者纏めて入力 -->
                <div class='add-area add-players-all-area'>
                    <div class='add-header add-header-players-all'>
                        出演者
                    </div>

                    <input type='text' id='add_players_all' class='add-players-all'>

                    <button class='add-players-all-button' onclick="getPlayersAll()">反映</button>
                </div>

                <!-- 配役と分類 -->
                <div class='add-area add-players-groups-area'>
                    <!-- 配役 -->
                    <div class='add-players-area'>
                        <div class='add-header add-header-players-groups'>
                            配役
                        </div>

                        <div class='add-players-button-block'>
                            <!-- 表 -->
                            <div class='add-players-box'>
                                <!-- ヘッダー -->
                                <div class='add-players-headerline'>
                                    <div class='add-players-cell add-players-header-cell add-players-cell-group'>
                                        分類
                                    </div>
                                    <div class='add-players-cell add-players-header-cell add-players-cell-roll'>
                                        役名
                                    </div>
                                    <div class='add-players-cell add-players-header-cell add-players-cell-player'>
                                        役者
                                    </div>
                                    <div class='add-players-cell add-players-header-cell add-players-cell-member'>
                                        劇団員
                                    </div>
                                </div>

                                <!-- 中身 -->
                                <div id='add_players_bodyblock' class='add-players-bodyblock'>
                                    <div id='add_players_bodyline_1' class='add-players-playerline'>
                                        <div class='add-players-cell add-players-line-cell add-players-cell-group'>
                                            <select id='add_players_group_1' class='add-players-input add-players-input-text add-players-group' onchange="chooseGroup()">
                                                <option hidden>選択</option>
                                            </select>
                                        </div>
                                        <div class='add-players-cell add-players-line-cell add-players-cell-roll'>
                                            <input type='text' id='add_players_roll_1' class='add-players-input add-players-input-text add-players-roll' onkeyup="getRoll()">
                                        </div>
                                        <div class='add-players-cell add-players-line-cell add-players-cell-player'>
                                            <input type='text' id='add_players_player_1' class='add-players-input add-players-input-text add-players-player'>
                                        </div>
                                        <div class='add-players-cell add-players-line-cell add-players-cell-member'>
                                            <input type='checkbox' id='add_players_member_1'  class='add-players-input add-players-member'>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>

                            <!-- フォームボタン -->
                            <div class='add-add-minus-button-area'>
                                <div id='add_minus_button_area_players_form' class='add-minus-button-area'>
                                    <button class='add-add-button' onclick="minusPlayerForm()">
                                        <div class='add-add-button-icon'>
                                            <i class="fa-solid fa-minus"></i>
                                        </div>
                                    </button>
                                </div>
                                <div id='add_add_button_area_players_form' class='add-add-button-area'>
                                    <button class='add-add-button' onclick="plusPlayerForm()">
                                        <div class='add-add-button-icon'>
                                            <i class='fa-solid fa-plus'></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <!-- 分類 -->
                    <div class='add-groups-area'>
                        <div class='add-header add-header-players-groups'>
                            分類
                        </div>

                        <div class="add-groups-button-block">
                            <!-- 表 -->
                            <div class='add-groups-box'>
                                <!-- ヘッダー -->
                                <div class='add-groups-headerline'>
                                    <div class='add-groups-header-cell add-groups-cell-group'>
                                        分類名
                                    </div>
                                </div>

                                <!-- 中身 -->
                                <div id='add_groups_bodyblock' class='add-groups-bodyblock'>
                                    <div id='add_groups_bodyline_1' class='add-groups-groupline'>
                                        <div class='add-groups-line-cell add-groups-cell-group'>
                                            <input type='text' id='add_groups_group_1' class='add-groups-group' onkeyup="getGroup()">
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>

                            <!-- フォームボタン -->
                            <div class='add-add-minus-button-area'>
                                <div id='add_minus_button_area_groups_form' class='add-minus-button-area'>
                                    <button class='add-add-button' onclick="minusGroupForm()">
                                        <div class='add-add-button-icon'>
                                            <i class="fa-solid fa-minus"></i>
                                        </div>
                                    </button>
                                </div>
                                <div id='add_add_button_area_groups_form' class='add-add-button-area'>
                                    <button class='add-add-button' onclick="plusGroupForm()">
                                        <div class='add-add-button-icon'>
                                            <i class='fa-solid fa-plus'></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 役感想 -->
                <div class='add-area add-player-impressions-area'>
                    <!-- 表 -->
                    <div class='add-player-impressions-box'>
                        <!-- ヘッダー -->
                        <div class='add-player-impressions-headerline'>
                            <div class='add-players-impressions-cell add-player-impressions-header-cell add-player-impressions-cell-roll'>
                                役名
                            </div>
                            <div class='add-players-impressions-cell add-player-impressions-header-cell add-player-impressions-cell-impression'>
                                感想
                            </div>
                            <div class='add-players-impressions-cell add-player-impressions-header-cell add-player-impressions-cell-photo'>
                                写真
                            </div>
                        </div>

                        <!-- 中身 -->
                        <div id='add_player_impressions_bodyblock' class='add-player-impression-bodyblock'>
                            <div id='add_player_impressions_bodyline_1' class='add-player-impressions-bodyline'>
                                <div class='add-players-impressions-cell add-player-impressions-body-cell add-player-impressions-cell-roll'>
                                    <select id='add_player_impressions_roll_1' class='add-player-impressions-input add-player-impressions-roll' onchange="chooseRoll()">
                                        <option hidden>選択</option>
                                    </select>
                                </div>
                                <div class='add-players-impressions-cell add-player-impressions-body-cell add-player-impressions-cell-impression'>
                                    <textarea id='add_player_impressions_impression_1' class='add-player-impressions-input add-player-impressions-impression' placeholder="どうだった？"></textarea>  
                                </div>
                                <div class='add-players-impressions-cell add-player-impressions-body-cell add-player-impressions-cell-photo'>
                                    <button type='button' id='add_player_impressions_photo_button_1' class='add-player-impressions-photo-button' onclick="sendFileNumber(1)">
                                        +選択
                                    </button>
                                    <input type='file' id='add_player_impressions_photo_1' class='add-player-impressions-photo' onchange="previewFile(this)">
                                    
                                    <img id="add_player_impressions_photo_preview_1" class='add-player-impressions-photo-preview'>
                                </div>
                            </div>
                        </div>
                            
                    </div>

                    <!-- フォームボタン -->
                    <div class='add-add-minus-button-area'>
                        <div id='add_minus_button_area_player_impressions_form' class='add-minus-button-area'>
                            <button class='add-add-button' onclick="minusPlayerImpressionForm()">
                                <div class='add-add-button-icon'>
                                    <i class="fa-solid fa-minus"></i>
                                </div>
                            </button>
                        </div>
                        <div id='add_add_button_area_player_impressions_form' class='add-add-button-area'>
                            <button class='add-add-button' onclick="plusPlayerImpressionForm()">
                                <div class='add-add-button-icon'>
                                    <i class='fa-solid fa-plus'></i>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 歴史 -->
                <div class='add-area add-story-area'>
                    <div class='add-header'>
                        歴史
                    </div>
                    <textarea id='add_history' class='add-story' placeholder="本当は？"></textarea>
                </div>

                <!-- その他 -->
                <div class='add-area add-others-area'>
                    <div class='add-header add-header-others'>
                        その他
                    </div>

                    <div class='add-others-button-block'>
                        <!-- 表 -->
                        <div class='add-others-box'>
                            <!-- ヘッダー -->
                            <div class='add-others-headerline'>
                                <div class='add-others-cell add-others-header-cell add-others-cell-title'>
                                    題目
                                </div>
                                <div class='add-others-cell add-others-header-cell add-others-cell-impression'>
                                    感想
                                </div>
                            </div>

                            <!-- 中身 -->
                            <div id='add_others_bodyblock' class='add-others-bodyblock'>
                                <div id='add_others_bodyline_1' class='add-others-bodyline'>
                                    <div class='add-others-cell add-others-body-cell add-others-cell-title'>
                                        <input type='text' id='add_others_title_1' class='add-others-input add-others-title'>
                                    </div>
                                    <div class='add-others-cell add-others-body-cell add-others-cell-impression'>
                                        <textarea id='add_others_impression_1' class='add-others-input add-others-impression' placeholder="どうだった？"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- フォームボタン -->
                        <div class='add-add-minus-button-area'>
                            <div id='add_minus_button_area_others_form' class='add-minus-button-area'>
                                <button class='add-add-button' onclick="minusOtherForm()">
                                    <div class='add-add-button-icon'>
                                        <i class="fa-solid fa-minus"></i>
                                    </div>
                                </button>
                            </div>
                            <div id='add_add_button_area_others_form' class='add-add-button-area'>
                                <button class='add-add-button' onclick="plusOtherForm()">
                                    <div class='add-add-button-icon'>
                                        <i class='fa-solid fa-plus'></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class='add-block-2'>
                <div class='add-special-area'>
                    <div class='add-special-header add-official-header'>
                        非公式
                    </div>
                    <input type='checkbox' id='add_official' class='add-special-input add-special'>
                </div>

                <div class='add-special-area'>
                    <div class='add-special-header'>
                        特典
                    </div>
                    <input type='checkbox' id='add_special' class='add-special-input add-special'>
                </div>

                <div class='add-special-area'>
                    <div class='add-special-header add-url-header'>
                        公式
                    </div>
                    <div class='add-url-DVD-movie-area'>
                        <div class='add-url-DVD-movie-block add-url-DVD-area'>
                            <div class='add-url-DVD-movie-header add-url-DVD-header'>
                                イーオシ
                            </div>
                            <input type='text' id='add_url_DVD' class='add-special-input add-special-input-text add-url-DVD'>
                        </div>

                        <div class='add-url-DVD-movie-block add-url-movie-area'>
                            <div class='add-url-DVD-movie-header add-url-movie-header'>
                                ゲキ×シネ
                            </div>
                            <input type='text' id='add_url_movie' class='add-special-input add-special-input-text add-url-movie'>
                        </div>
                    </div>
                </div>

                <div class='add-special-area'>
                    <div class='add-special-header add-category-header'>
                        カテゴリー
                    </div>
                    <select id='add_category' class='add-special-input add-special-input-text add-category'>
                        <option value="1" selected>いのうえ歌舞伎</option>
                        <option value="2">ネタモノ</option>
                        <option value="3">音もの</option>
                        <option value="4">その他</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- ボタン -->
        <div class='add-button-area'>
            <button type='button' class='add-button add-back-button'>
                <div class='add-button-icon'>
                    <i class='fa-solid fa-arrow-rotate-left'></i>
                </div>
            </button>

            <button type='submit' class='add-button add-submit-button' onclick="submitData()">
                <div class='add-button-icon'>
                    送信
                </div>
            </button>
        </div>
    </main>

    <script>
        let location_number = 3;
        let player_number = 1;
        let group_number = 1;
        let player_impression_number = 1;
        let other_number = 1;
        let players = []; // 役者
        let option_groups_name = []; // 分類名
        let select_groups; // 分類名を入力したら、分類名のプルダウンメニューが増える。
        let select_groups_name = []; // 選択されてる分類名
        let option_rolls_name = []; // 役名
        let select_rolls; // 役名を入力したら、役名のプルダウンメニューが増える。
        let select_rolls_name = []; // 選択されてる役名
        let photos = [];
        const regex1 = /^[0-9]+$/; // 半角英数字入力のみに制限
        const regex2 = /^[ぁ-んー]+$/;
        const members = ['古田新太', '橋本じゅん', '高田聖子', '粟根まこと', '右近健一', '逆木圭一郎', '河野まさと', '村木よし子', 'インディ高橋', '山本カナコ', '礒野慎吾', '吉田メタル', '中谷さとみ', '保坂エマ', 'こぐれ修', '枯暮修', '竹田団吾', '羽野アキ', '羽野晶紀', '杉本恵美', 'タイソン大屋']; // 劇団員

        // 初期セット
        window.onload = function(){
            // 出演者一覧 出演者感想
            for(let i = 0; i < 3; i++) {
                plusPlayerForm();
                plusPlayerImpressionForm();
            }
            // 分類
            document.getElementById('add_minus_button_area_groups_form').style.visibility = 'hidden';
            // その他
            document.getElementById('add_minus_button_area_others_form').style.visibility = 'hidden';
        }

        // タイトルかな
        function getTitleKana() {
            let keyupTitle = document.getElementById('add_title').value;
            let keyupTitleLast = keyupTitle.slice(-1);
            if(keyupTitleLast.match(regex1) || keyupTitleLast.match(regex2)) {
                document.getElementById('add_title_kana').value = keyupTitle;
            }
        }

        // 出演者纏めて
        function getPlayersAll() {
            let keyupPlayers = document.getElementById('add_players_all').value;
            keyupPlayers = keyupPlayers.replace(' / ', '　');
            keyupPlayers = keyupPlayers.replace(' / ', '　');
            keyupPlayers = keyupPlayers.replace(' / ', '　');
            let tempPlayers = keyupPlayers.split(/,|、|　|  | /);
            players = tempPlayers.filter(Boolean);
            inputPlayersAll();
        }
        function inputPlayersAll() {
            players.forEach((player, index) => {
                if(player_number < index + 1) {
                    plusPlayerForm();
                }
                document.getElementById('add_players_player_' + (index + 1)).value = player;
                if(members.includes(player)) {
                    document.getElementById('add_players_member_' + (index + 1)).checked = true;
                }
            })
        }

        // 入力された分類名をプルダウンメニューに追加
        function getGroup() {
            const id = event.currentTarget.id;
            const id_number = id.replace('add_groups_group_', '');
            const inputGroup = event.currentTarget.value;
            option_groups_name[id_number - 1] = inputGroup;
            addOptionGroups();
        }
        function addOptionGroups(){
            select_groups = [].slice.call(document.querySelectorAll('[id^="add_players_group"]'));
            select_groups.forEach((select_group, number) => {
                select_group.innerHTML = '';
                let groupOption = document.createElement('option');
                groupOption.innerHTML = '選択';
                select_group.appendChild(groupOption);
                option_groups_name.forEach((name) => {
                    let groupOption = document.createElement('option');
                    groupOption.setAttribute('value',name);
                    groupOption.setAttribute('text',name);
                    if(name == select_groups_name[number]){
                        groupOption.setAttribute('selected', 'true'); //プルダウンメニューで選択された名前だった場合selected
                    }
                    groupOption.innerHTML = name;
                    select_group.appendChild(groupOption);
                })
            })
        }
        // 分類名が消えた時
        function removeOptionGroups(removeGroup) {
            let temp_option = option_groups_name.filter(function(name) {
                return name !== removeGroup;
            });
            option_groups_name = temp_option;

            select_groups = [].slice.call(document.querySelectorAll('[id^="add_players_group"]'));
            select_groups.forEach((select_group, number) => {
                select_group.innerHTML = '';
                let groupOption = document.createElement('option');
                groupOption.innerHTML = '選択';
                select_group.appendChild(groupOption);
                option_groups_name.forEach((name) => {
                    let groupOption = document.createElement('option');
                    groupOption.setAttribute('value',name);
                    groupOption.setAttribute('text',name);
                    if(name == select_groups_name[number]){
                        groupOption.setAttribute('selected', 'true'); //プルダウンメニューで選択された名前だった場合selected
                    } else if(select_groups_name[number] == removeGroup) {
                        select_groups_name[number] = null;
                    }
                    groupOption.innerHTML = name;
                    select_group.appendChild(groupOption);
                })
            })
        }

        // プルダウンメニューで選択された分類名を取得
        function chooseGroup(){
            const id = event.currentTarget.id;
            const id_number = id.replace('add_players_group_', '');
            const group = event.currentTarget.value;
            select_groups_name[id_number - 1] = group;
        }

        // 入力された役名をプルダウンメニューに追加
        function getRoll() {
            const id = event.currentTarget.id;
            const id_number = id.replace('add_players_roll_', '');
            const inputRoll = event.currentTarget.value;
            option_rolls_name[id_number - 1] = inputRoll;
            addOptionRolls();
        }
        function addOptionRolls(){
            select_rolls = [].slice.call(document.querySelectorAll('[id^="add_player_impressions_roll"]'));
            select_rolls.forEach((select_roll, number) => {
                select_roll.innerHTML = '';
                let rollOption = document.createElement('option');
                rollOption.innerHTML = '選択';
                select_roll.appendChild(rollOption);
                option_rolls_name.forEach((name) => {
                    let rollOption = document.createElement('option');
                    rollOption.setAttribute('value',name);
                    rollOption.setAttribute('text',name);
                    if(name == select_rolls_name[number]){
                        rollOption.setAttribute('selected', 'true'); //プルダウンメニューで選択された名前だった場合selected
                    }
                    rollOption.innerHTML = name;
                    select_roll.appendChild(rollOption);
                })
            })
        }
        function removeOptionRolls(removeRoll) {
            let temp_option = option_rolls_name.filter(function(name) {
                return name !== removeRoll;
            });
            option_rolls_name = temp_option;

            select_rolls = [].slice.call(document.querySelectorAll('[id^="add_player_impressions_roll"]'));
            select_rolls.forEach((select_roll, number) => {
                select_roll.innerHTML = '';
                let rollOption = document.createElement('option');
                rollOption.innerHTML = '選択';
                select_roll.appendChild(rollOption);
                option_rolls_name.forEach((name) => {
                    let rollOption = document.createElement('option');
                    rollOption.setAttribute('value',name);
                    rollOption.setAttribute('text',name);
                    if(name == select_rolls_name[number]){
                        rollOption.setAttribute('selected', 'true'); //プルダウンメニューで選択された名前だった場合selected
                    } else if(select_rolls_name[number] == removeRoll) {
                        select_rolls_name[number] = null;
                    }
                    rollOption.innerHTML = name;
                    select_roll.appendChild(rollOption);
                })
            })
        }

        // プルダウンメニューで選択された役名を取得
        function chooseRoll(){
            const id = event.currentTarget.id;
            const id_number = id.replace('add_player_impressions_roll_', '');
            const name = event.currentTarget.value;
            select_rolls_name[id_number - 1] = name;
        }

        // 写真プレビュー  
        let fileNumber = 0;
        function sendFileNumber(number){
            fileNumber = number;
            document.querySelector("#add_player_impressions_photo_" + fileNumber).click();
        }

        function previewFile(photo_path) {
            var fileData = new FileReader();
            fileData.onload = (function() {
                //id属性が付与されているimgタグのsrc属性に、fileReaderで取得した値の結果を入力することで
                //プレビュー表示している
                document.getElementById('add_player_impressions_photo_preview_' + fileNumber).src = fileData.result;
            });
            fileData.readAsDataURL(photo_path.files[0]);
            photos[fileNumber] = photo_path.files[0];
        };

        // document.querySelector("#add_player_impressions_photo_button_" + number).addEventListener("click", () => {
        //     document.querySelector("#add_player_impressions_photo_" + number).click();
        // });

        // データ送信
        async function submitData() {
            let sendData;
            // データセット
            let title;
            let title_kana;
            let duration_from;
            let duration_to;
            let locations = [];
            let impression;
            let story;
            let author;
            let groups = [];
            let characters = [];
            let history;
            let others = [];
            let official = true;
            let special = false;
            let eoshi;
            let gekicine;
            let category = 1;

            // タイトル
            title = document.getElementById('add_title').value;
            title.trim();
            title_kana = document.getElementById('add_title_kana').value;
            title_kana.trim();
            if(!title && !title_kana){
                return;
            }

            // 公演期間
            duration_from = document.getElementById('add_duration_from').value;
            duration_to = document.getElementById('add_duration_to').value;

            // 公演場所
            k = 0;
            for(let i = 0; i < location_number; i++){
                let location_prefecture = document.getElementById('add_location_prefecture_' + (i + 1)).value;
                let location_theater = document.getElementById('add_location_theater_' + (i + 1)).value;
                location_theater.trim();
                if(location_prefecture && location_prefecture != '選択' && location_theater) {
                    locations[k] = [];
                    locations[k].prefecture = parseInt(location_prefecture, 10);
                    locations[k].theater = location_theater;
                    k++;
                }                 
            }

            // 感想
            impression = document.getElementById('add_impression').value;
            impression.trim();

            // あらすじ
            story = document.getElementById('add_story').value;
            story.trim();

            // 脚本
            author = document.getElementById('add_author').value;
            author.trim();
            author = author.replace(/\s+/g, "");

            // 分類
            for(let i = 0; i < group_number; i++) {
                let group = document.getElementById('add_groups_group_' + (i + 1)).value;
                groups.push(group.trim());
            }

            // 配役
            k = 0;
            for(let i = 0; i < player_number; i++) {
                let player_group = document.getElementById('add_players_group_' + (i + 1)).value;
                let player_roll = document.getElementById('add_players_roll_' + (i + 1)).value;
                let player_player = document.getElementById('add_players_player_' + (i + 1)).value;
                let player_member = document.getElementById('add_players_member_' + (i + 1)).checked;
                player_group.trim();
                player_roll.trim();
                player_roll.replace(/\s+/g, "");
                player_player.trim();
                player_player.replace(/\s+/g, "");
                if(player_roll && player_player) {
                    console.log(k);
                    if(!player_group || player_group == '選択') {
                        player_group = null;
                    }
                    if(player_member) { 
                        player_member = 1;
                    } else {
                        player_member = 0;
                    }
                    characters[k] = [];
                    characters[k].group = player_group;
                    characters[k].roll = player_roll;
                    characters[k].player = player_player;
                    characters[k].member = player_member;
                    k++;
                }
            }

            // 役感想
            for(let i = 0; i < player_impression_number; i++) {
                let player_impressions_roll = document.getElementById('add_player_impressions_roll_' + (i + 1)).value;
                player_impressions_roll.trim();
                player_impressions_roll.replace(/\s+/g, "");
                let player_impressions_impression = document.getElementById('add_player_impressions_impression_' + (i + 1)).value;
                player_impressions_impression.trim();
                 
                if(player_impressions_roll && player_impressions_roll != '選択' && player_impressions_impression) {
                    const character_index = characters.findIndex((v) => v.roll === player_impressions_roll);
                    if(character_index > -1) {
                        characters[character_index].impression = player_impressions_impression;
                        characters[character_index].photo = photos[i + 1];
                    }
                }
            }

            // 歴史
            history = document.getElementById('add_history').value;
            history.trim();

            // その他
            k = 0;
            for(let i = 0; i < other_number; i++) {
                let other_title = document.getElementById('add_others_title_' + (i + 1)).value;
                other_title.trim();
                let other_impression = document.getElementById('add_others_impression_' + (i + 1)).value;
                other_impression.trim();

                if(other_title && other_impression) { 
                    others[k] = [];
                    others[k].title = other_title;
                    others[k].impression = other_impression;
                    k++;
                }
            }

            // 非公式
            official = document.getElementById('add_official');

            // 特典
            special = document.getElementById('add_special');

            // イーオシ
            eoshi = document.getElementById('add_url_DVD').value;
            eoshi.trim();

            // ゲキ×シネ
            gekicine = document.getElementById('add_url_movie').value;
            gekicine.trim();

            // カテゴリー
            category = document.getElementById('add_category').value;

            const formData = new FormData();
            formData.append('title', title);
            formData.append('title_kana', title_kana);
            formData.append('duration_from', duration_from);
            formData.append('duration_to', duration_to);
            formData.append('locations', locations);
            formData.append('impression', impression);
            formData.append('story', story);
            formData.append('author', author);
            formData.append('groups', groups);
            formData.append('characters', characters);
            formData.append('history', history);
            formData.append('others', others);

            // const response = await axios.post('/api/add', formData);

            // if (response.status !== 201) {
            //     return false;
            // }

        }

        // フォーム関係
        // 劇場フォーム
        function plusLocationForm() {
            if(location_number < 10) {
                location_number += 1;
                let locations_block = document.getElementById('add_locations_block');
                let new_locations_line = locations_block.lastElementChild.cloneNode(true);
                
                // id変更入力値変更
                new_locations_line.id = 'add_location_' + location_number;
                new_locations_line.getElementsByClassName('add-location-prefecture')[0].id = 'add_location_prefecture_' + location_number;
                new_locations_line.getElementsByClassName('add-location-prefecture')[0].selectedIndex = 0;
                new_locations_line.getElementsByClassName('add-location-theater')[0].id = 'add_location_theater_' + player_number;
                new_locations_line.getElementsByClassName('add-location-theater')[0].value = null;

                // 追加
                locations_block.appendChild(new_locations_line);

                if(location_number === 1){
                    document.getElementById('add_minus_button_area_locations_form').style.visibility = 'hidden';
                } else if(location_number === 2) {
                    document.getElementById('add_minus_button_area_locations_form').style.visibility = 'visible';
                } else if (location_number === 9) {
                    document.getElementById('add_add_button_area_locations_form').style.visibility = 'visible';
                } else if (location_number === 10) {
                    document.getElementById('add_add_button_area_locations_form').style.visibility = 'hidden';
                }
            }
        }
        function minusLocationForm() {
            if(location_number > 1) {
                let locations_block = document.getElementById('add_locations_block');
                let delete_locations_line = document.getElementById('add_location_' + location_number);

                // 削除
                locations_block.removeChild(delete_locations_line);

                location_number -= 1;

                if(location_number === 1){
                    document.getElementById('add_minus_button_area_locations_form').style.visibility = 'hidden';
                } else if(location_number === 2) {
                    document.getElementById('add_minus_button_area_locations_form').style.visibility = 'visible';
                } else if (location_number === 9) {
                    document.getElementById('add_add_button_area_locations_form').style.visibility = 'visible';
                } else if (location_number === 10) {
                    document.getElementById('add_add_button_area_locations_form').style.visibility = 'hidden';
                }
            }
        }

        // 出演者フォーム
        function plusPlayerForm() {
            if(player_number < 50) {
                player_number += 1;
                let players_bodyblock = document.getElementById('add_players_bodyblock');
                let new_players_bodyline = players_bodyblock.lastElementChild.cloneNode(true);
                
                // id変更入力値変更
                new_players_bodyline.id = 'add_players_bodyline_' + player_number;
                new_players_bodyline.getElementsByClassName('add-players-group')[0].id = 'add_players_group_' + player_number;
                new_players_bodyline.getElementsByClassName('add-players-group')[0].selectedIndex = 0;
                new_players_bodyline.getElementsByClassName('add-players-roll')[0].id = 'add_players_roll_' + player_number;
                new_players_bodyline.getElementsByClassName('add-players-roll')[0].value = null;
                new_players_bodyline.getElementsByClassName('add-players-player')[0].id = 'add_players_player_' + player_number;
                new_players_bodyline.getElementsByClassName('add-players-player')[0].value = null;
                new_players_bodyline.getElementsByClassName('add-players-member')[0].id = 'add_players_member_' + player_number;
                new_players_bodyline.getElementsByClassName('add-players-member')[0].checked= false;

                // 追加
                players_bodyblock.appendChild(new_players_bodyline);

                if(player_number === 1){
                    document.getElementById('add_minus_button_area_players_form').style.visibility = 'hidden';
                } else if(player_number === 2) {
                    document.getElementById('add_minus_button_area_players_form').style.visibility = 'visible';
                } else if (player_number === 49) {
                    document.getElementById('add_add_button_area_players_form').style.visibility = 'visible';
                } else if (player_number === 50) {
                    document.getElementById('add_add_button_area_players_form').style.visibility = 'hidden';
                }

                if(group_number < player_number && group_number < 5) {
                    document.getElementById('add_add_button_area_groups_form').style.visibility = 'visible';
                } else {
                    minusGroupForm();
                    document.getElementById('add_add_button_area_groups_form').style.visibility = 'hidden';
                }

                if(player_impression_number < player_number && player_impression_number < 50) {
                    document.getElementById('add_add_button_area_player_impressions_form').style.visibility = 'visible';
                } else {
                    minusPlayerImpressionForm();
                    document.getElementById('add_add_button_area_player_impressions_form').style.visibility = 'hidden';
                }
            }
        }
        function minusPlayerForm() {
            if(player_number > 1) {
                let players_bodyblock = document.getElementById('add_players_bodyblock');
                let delete_players_bodyline = document.getElementById('add_players_bodyline_' + player_number);
                let removeRoll = delete_players_bodyline.getElementsByClassName('add-players-roll')[0].value;
                if(removeRoll && removeRoll != '選択') {
                    removeOptionRolls(removeRoll);
                }

                // 削除
                players_bodyblock.removeChild(delete_players_bodyline);

                player_number -= 1;

                if(player_number === 1){
                    document.getElementById('add_minus_button_area_players_form').style.visibility = 'hidden';
                } else if(player_number === 2) {
                    document.getElementById('add_minus_button_area_players_form').style.visibility = 'visible';
                } else if (player_number === 49) {
                    document.getElementById('add_add_button_area_players_form').style.visibility = 'visible';
                } else if (player_number === 50) {
                    document.getElementById('add_add_button_area_players_form').style.visibility = 'hidden';
                }

                if(group_number < player_number && group_number < 5) {
                    document.getElementById('add_add_button_area_groups_form').style.visibility = 'visible';
                } else {
                    minusGroupForm();
                    document.getElementById('add_add_button_area_groups_form').style.visibility = 'hidden';
                }

                if(player_impression_number < player_number && player_impression_number < 50) {
                    document.getElementById('add_add_button_area_player_impressions_form').style.visibility = 'visible';
                } else {
                    minusPlayerImpressionForm();
                    document.getElementById('add_add_button_area_player_impressions_form').style.visibility = 'hidden';
                }
            }
        }

        // 分類フォーム
        function plusGroupForm() {
            if(group_number < 5) {
                group_number += 1;
                let groups_bodyblock = document.getElementById('add_groups_bodyblock');
                let new_groups_bodyline = groups_bodyblock.lastElementChild.cloneNode(true);
                
                // id変更入力値変更
                new_groups_bodyline.id = 'add_groups_bodyline_' + group_number;
                new_groups_bodyline.getElementsByClassName('add-groups-group')[0].id = 'add_groups_group_' + group_number;
                new_groups_bodyline.getElementsByClassName('add-groups-group')[0].value = null;
                // 追加
                groups_bodyblock.appendChild(new_groups_bodyline);

                if(group_number === 1){
                    document.getElementById('add_minus_button_area_groups_form').style.visibility = 'hidden';
                } else if(group_number === 2) {
                    document.getElementById('add_minus_button_area_groups_form').style.visibility = 'visible';
                } 
                
                if(group_number >= player_number || group_number === 5) {
                    document.getElementById('add_add_button_area_groups_form').style.visibility = 'hidden';
                } else if (group_number < 4 && group_number < player_number) {
                    document.getElementById('add_add_button_area_groups_form').style.visibility = 'visible';
                }
            }
        }
        function minusGroupForm() {
            if(group_number > 1) {
                let groups_bodyblock = document.getElementById('add_groups_bodyblock');
                let delete_groups_bodyline = document.getElementById('add_groups_bodyline_' + group_number);
                let removeGroup = delete_groups_bodyline.getElementsByClassName('add-groups-group')[0].value;
                if(removeGroup && removeGroup != '選択') {
                    removeOptionGroups(removeGroup);
                }

                // 削除
                groups_bodyblock.removeChild(delete_groups_bodyline);

                group_number -= 1;

                if(group_number === 1){
                    document.getElementById('add_minus_button_area_groups_form').style.visibility = 'hidden';
                } else if(group_number === 2) {
                    document.getElementById('add_minus_button_area_groups_form').style.visibility = 'visible';
                }
                
                if(group_number >= player_number || group_number === 5) {
                    document.getElementById('add_add_button_area_groups_form').style.visibility = 'hidden';
                } else if (group_number < 4 && group_number < player_number) {
                    document.getElementById('add_add_button_area_groups_form').style.visibility = 'visible';
                }
            }
        }

        // 出演者感想フォーム
        function plusPlayerImpressionForm() {
            if(player_impression_number < 50 && player_impression_number < player_number) {
                player_impression_number += 1;
                let player_impressions_bodyblock = document.getElementById('add_player_impressions_bodyblock');
                let new_player_impressions_bodyline = player_impressions_bodyblock.lastElementChild.cloneNode(true);
                
                // id変更入力値変更
                new_player_impressions_bodyline.id = 'add_player_impressions_bodyline_' + player_impression_number;
                new_player_impressions_bodyline.getElementsByClassName('add-player-impressions-roll')[0].id = 'add_player_impressions_roll_' + player_impression_number;
                new_player_impressions_bodyline.getElementsByClassName('add-player-impressions-roll')[0].selectedIndex = 0;
                new_player_impressions_bodyline.getElementsByClassName('add-player-impressions-impression')[0].id = 'add_player_impressions_impression_' + player_impression_number;
                new_player_impressions_bodyline.getElementsByClassName('add-player-impressions-impression')[0].value = null;
                new_player_impressions_bodyline.getElementsByClassName('add-player-impressions-photo-button')[0].id = 'add-player_impressions_photo_button_' + player_impression_number;
                new_player_impressions_bodyline.getElementsByClassName('add-player-impressions-photo-button')[0].setAttribute('onclick', 'sendFileNumber(' + player_impression_number + ')');
                new_player_impressions_bodyline.getElementsByClassName('add-player-impressions-photo')[0].id = 'add_player_impressions_photo_' + player_impression_number;
                new_player_impressions_bodyline.getElementsByClassName('add-player-impressions-photo')[0].value = null;
                new_player_impressions_bodyline.getElementsByClassName('add-player-impressions-photo-preview')[0].id = 'add_player_impressions_photo_preview_' + player_impression_number;
                new_player_impressions_bodyline.getElementsByClassName('add-player-impressions-photo-preview')[0].src = '';

                // 追加
                player_impressions_bodyblock.appendChild(new_player_impressions_bodyline);

                if(player_impression_number === 1){
                    document.getElementById('add_minus_button_area_player_impressions_form').style.visibility = 'hidden';
                } else if(player_impression_number === 2) {
                    document.getElementById('add_minus_button_area_player_impressions_form').style.visibility = 'visible';
                } 
                
                if(player_impression_number >= player_number || player_impression_number === 50) {
                    document.getElementById('add_add_button_area_player_impressions_form').style.visibility = 'hidden';
                } else if (player_impression_number < 50 && player_impression_number < player_number) {
                    document.getElementById('add_add_button_area_player_impressions_form').style.visibility = 'visible';
                }
            }
        }
        function minusPlayerImpressionForm() {
            if(player_impression_number > 1) {
                let player_impressions_bodyblock = document.getElementById('add_player_impressions_bodyblock');
                let delete_player_impressions_bodyline = document.getElementById('add_player_impressions_bodyline_' + player_impression_number);

                // 削除
                player_impressions_bodyblock.removeChild(delete_player_impressions_bodyline);

                player_impression_number -= 1;

                if(player_impression_number === 1){
                    document.getElementById('add_minus_button_area_player_impressions_form').style.visibility = 'hidden';
                } else if(player_impression_number === 2) {
                    document.getElementById('add_minus_button_area_player_impressions_form').style.visibility = 'visible';
                } 

                if(player_impression_number >= player_number || player_impression_number === 50) {
                    document.getElementById('add_add_button_area_player_impressions_form').style.visibility = 'hidden';
                } else if (player_impression_number < 50 && player_impression_number < player_number) {
                    document.getElementById('add_add_button_area_player_impressions_form').style.visibility = 'visible';
                }
            }
        }

        // その他フォーム
        function plusOtherForm() {
            if(other_number < 10) {
                other_number += 1;
                let others_bodyblock = document.getElementById('add_others_bodyblock');
                let new_others_bodyline = others_bodyblock.lastElementChild.cloneNode(true);
                
                // id変更入力値変更
                new_others_bodyline.id = 'add_others_bodyline_' + other_number;
                new_others_bodyline.getElementsByClassName('add-others-title')[0].id = 'add_others_title_' + other_number;
                new_others_bodyline.getElementsByClassName('add-others-title')[0].value = null;
                new_others_bodyline.getElementsByClassName('add-others-impression')[0].id = 'add_others_impression_' + other_number;
                new_others_bodyline.getElementsByClassName('add-others-impression')[0].value = null;

                // 追加
                others_bodyblock.appendChild(new_others_bodyline);

                if(other_number === 1){
                    document.getElementById('add_minus_button_area_others_form').style.visibility = 'hidden';
                } else if(other_number === 2) {
                    document.getElementById('add_minus_button_area_others_form').style.visibility = 'visible';
                } else if (other_number === 9) {
                    document.getElementById('add_add_button_area_others_form').style.visibility = 'visible';
                } else if (other_number === 10) {
                    document.getElementById('add_add_button_area_others_form').style.visibility = 'hidden';
                }
            }
        }
        function minusOtherForm() {
            if(other_number > 1) {
                let others_bodyblock = document.getElementById('add_others_bodyblock');
                let delete_others_bodyline = document.getElementById('add_others_bodyline_' + other_number);

                // 削除
                others_bodyblock.removeChild(delete_others_bodyline);

                other_number -= 1;

                if(other_number === 1){
                    document.getElementById('add_minus_button_area_others_form').style.visibility = 'hidden';
                } else if(other_number === 2) {
                    document.getElementById('add_minus_button_area_others_form').style.visibility = 'visible';
                } else if (other_number === 9) {
                    document.getElementById('add_add_button_area_others_form').style.visibility = 'visible';
                } else if (other_number === 10) {
                    document.getElementById('add_add_button_area_others_form').style.visibility = 'hidden';
                }
            }
        }
        
    </script>
</body>
</html>