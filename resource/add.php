<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
    <link rel="icon" href="../iconStar.png" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
    <link href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" rel="stylesheet">
    <title>新規追加</title>
</head>
<?php

function h($str)
{
    return htmlentities($str, ENT_QUOTES, 'UTF-8');
}

?>

<body>    
    <main class="add">
        <div class="add-block">
            <div class="add-block-1">
                <!-- タイトル -->
                <div class="add-area add-title-area">
                    <div class="add-header">
                        タイトル
                    </div>
                    <div class="add-title-kana-area">
                        <input type="text" id="add_title" class="add-title" placeholder="タイトル" onkeyup="getTitle()">
                        <input type="text" id="add_title_kana" class="add-title add-title-kana" placeholder="たいとる">
                    </div>
                    
                </div>

                <!-- 公演期間 -->
                <div class="add-area add-duration-area">
                    <div class="add-header">
                        公演期間
                    </div>
                    <div class="add-duration-input-area">
                        <input type="date" value="2023-01-04" id="add_duration_from" class="add-duration"> 
                        <div class="add-duration-conection">
                            ~
                        </div>
                        <input type="date" value="2023-01-12" id="add_duration_to" class="add-duration"> 
                    </div>
                </div>

                <!-- 公演場所 -->
                <div class="add-area add-location-area">
                    <div class="add-header">
                        公演場所
                    </div>
                    
                    <div class="add-locations-button-area">
                        <div id="add_locations_block" class="add-locations">
                            <!-- 1セット -->
                            <div id="add_location_1" class="add-location">
                                <select id="add_location_prefecture_1" class="add-location-prefecture">
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

                                <input type="text" id="add_location_theater_1" class="add-location-theater">
                            </div>

                            <!-- 2セット -->
                            <div id="add_location_2" class="add-location">
                                <select id="add_location_prefecture_2" class="add-location-prefecture">
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

                                <input type="text" id="add_location_theater_2" class="add-location-theater">
                            </div>

                            <!-- 3セット -->
                            <div id="add_location_3" class="add-location">
                                <select id="add_location_prefecture_3" class="add-location-prefecture">
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

                                <input type="text" id="add_location_theater_3" class="add-location-theater">
                            </div>
                        </div>

                        <!-- フォームボタン -->
                        <div class="add-add-minus-button-area">
                            <div id="add_minus_button_area_locations_form" class="add-minus-button-area">
                                <button id="add_minus_location_button" class="add-add-button" onclick="minusLocationForm()">
                                    <div class="add-add-button-icon">
                                        <i class="fa-solid fa-minus"></i>
                                    </div>
                                </button>
                            </div>
                            <div id="add_add_button_area_locations_form" class="add-add-button-area">
                                <button id="add_plus_location_button" class="add-add-button" onclick="plusLocationForm()">
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
                    <textarea id="add_impression" class="add-impression" placeholder="どうだった？"></textarea>
                </div>

                <!-- あらすじ -->
                <div class="add-area add-story-area">
                    <div class="add-header">
                        あらすじ
                    </div>
                    <textarea id="add_story" class="add-story" placeholder="あらすじ"></textarea>
                </div>

                <!-- 脚本 -->
                <div class="add-area add-author-area">
                    <div class="add-header">
                        作
                    </div>
                    <input type="text" id="add_author" class="add-author">
                </div>
                
                <!-- 出演者纏めて入力 -->
                <div class="add-area add-players-all-area">
                    <div class="add-header add-header-players-all">
                        出演者
                    </div>

                    <input type="text" id="add_players_all" class="add-players-all">

                    <button id="add_player_all_button" class="add-players-all-button" onclick="getAllPlayers()">反映</button>
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
                                    <div class="add-players-cell add-players-header-cell add-players-cell-roll">
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
                                <div id="add_players_bodyblock" class="add-players-bodyblock">
                                    <div id="add_players_bodyline_1" class="add-players-playerline">
                                        <div class="add-players-cell add-players-line-cell add-players-cell-group">
                                            <select id="add_players_group_1" class="add-players-input add-players-input-text add-players-group" onchange="chooseGroup(this)">
                                                <option hidden>選択</option>
                                            </select>
                                        </div>
                                        <div class="add-players-cell add-players-line-cell add-players-cell-roll">
                                            <input type="text" id="add_players_roll_1" class="add-players-input add-players-input-text add-players-roll" onkeyup="getRoll(this)">
                                        </div>
                                        <div class="add-players-cell add-players-line-cell add-players-cell-player">
                                            <input type="text" id="add_players_player_1" class="add-players-input add-players-input-text add-players-player">
                                        </div>
                                        <div class="add-players-cell add-players-line-cell add-players-cell-member">
                                            <input type="checkbox" id="add_players_member_1"  class="add-players-input add-players-member">
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>

                            <!-- フォームボタン -->
                            <div class="add-add-minus-button-area">
                                <div id="add_minus_button_area_players_form" class="add-minus-button-area">
                                    <button id="add_minus_player_button" class="add-add-button">
                                        <div class="add-add-button-icon">
                                            <i class="fa-solid fa-minus"></i>
                                        </div>
                                    </button>
                                </div>
                                <div id="add_add_button_area_players_form" class="add-add-button-area">
                                    <button id="add_plus_player_button" class="add-add-button">
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
                                <div id="add_groups_bodyblock" class="add-groups-bodyblock">
                                    <div id="add_groups_bodyline_1" class="add-groups-groupline">
                                        <div class="add-groups-line-cell add-groups-cell-group">
                                            <input type="text" id="add_groups_group_1" class="add-groups-group" onkeyup="getGroup(this)">
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>

                            <!-- フォームボタン -->
                            <div class="add-add-minus-button-area">
                                <div id="add_minus_button_area_groups_form" class="add-minus-button-area">
                                    <button class="add-add-button" onclick="minusGroupForm()">
                                        <div class="add-add-button-icon">
                                            <i class="fa-solid fa-minus"></i>
                                        </div>
                                    </button>
                                </div>
                                <div id="add_add_button_area_groups_form" class="add-add-button-area">
                                    <button class="add-add-button" onclick="plusGroupForm()">
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
                <div class="add-area add-player-impressions-area">
                    <!-- 表 -->
                    <div class="add-player-impressions-box">
                        <!-- ヘッダー -->
                        <div class="add-player-impressions-headerline">
                            <div class="add-players-impressions-cell add-player-impressions-header-cell add-player-impressions-cell-roll">
                                役名
                            </div>
                            <div class="add-players-impressions-cell add-player-impressions-header-cell add-player-impressions-cell-impression">
                                感想
                            </div>
                            <div class="add-players-impressions-cell add-player-impressions-header-cell add-player-impressions-cell-photo">
                                写真
                            </div>
                        </div>

                        <!-- 中身 -->
                        <div id="add_player_impressions_bodyblock" class="add-player-impression-bodyblock">
                            <div id="add_player_impressions_bodyline_1" class="add-player-impressions-bodyline">
                                <div class="add-players-impressions-cell add-player-impressions-body-cell add-player-impressions-cell-roll">
                                    <select id="add_player_impressions_roll_1" class="add-player-impressions-input add-player-impressions-roll" onchange="chooseRoll(this)">
                                        <option hidden>選択</option>
                                    </select>
                                </div>
                                <div class="add-players-impressions-cell add-player-impressions-body-cell add-player-impressions-cell-impression">
                                    <textarea id="add_player_impressions_impression_1" class="add-player-impressions-input add-player-impressions-impression" placeholder="どうだった？"></textarea>  
                                </div>
                                <div class="add-players-impressions-cell add-player-impressions-body-cell add-player-impressions-cell-photo">
                                    <button type="button" id="add_player_impressions_photo_button_1" class="add-player-impressions-photo-button" onclick="sendFileNumber(1)">
                                        +選択
                                    </button>
                                    <input type="file" id="add_player_impressions_photo_1" class="add-player-impressions-photo" onchange="previewFile(this)">
                                    
                                    <img id="add_player_impressions_photo_preview_1" class="add-player-impressions-photo-preview">
                                </div>
                            </div>
                        </div>
                            
                    </div>

                    <!-- フォームボタン -->
                    <div class="add-add-minus-button-area">
                        <div id="add_minus_button_area_player_impressions_form" class="add-minus-button-area">
                            <button class="add-add-button" onclick="minusPlayerImpressionForm()">
                                <div class="add-add-button-icon">
                                    <i class="fa-solid fa-minus"></i>
                                </div>
                            </button>
                        </div>
                        <div id="add_add_button_area_player_impressions_form" class="add-add-button-area">
                            <button class="add-add-button" onclick="plusPlayerImpressionForm()">
                                <div class="add-add-button-icon">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 歴史 -->
                <div class="add-area add-story-area">
                    <div class="add-header">
                        歴史
                    </div>
                    <textarea id="add_history" class="add-story" placeholder="本当は？"></textarea>
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
                            <div id="add_others_bodyblock" class="add-others-bodyblock">
                                <div id="add_others_bodyline_1" class="add-others-bodyline">
                                    <div class="add-others-cell add-others-body-cell add-others-cell-title">
                                        <input type="text" id="add_others_title_1" class="add-others-input add-others-title">
                                    </div>
                                    <div class="add-others-cell add-others-body-cell add-others-cell-impression">
                                        <textarea id="add_others_impression_1" class="add-others-input add-others-impression" placeholder="どうだった？"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- フォームボタン -->
                        <div class="add-add-minus-button-area">
                            <div id="add_minus_button_area_others_form" class="add-minus-button-area">
                                <button class="add-add-button" onclick="minusOtherForm()">
                                    <div class="add-add-button-icon">
                                        <i class="fa-solid fa-minus"></i>
                                    </div>
                                </button>
                            </div>
                            <div id="add_add_button_area_others_form" class="add-add-button-area">
                                <button class="add-add-button" onclick="plusOtherForm()">
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
                    <div class="add-special-header add-official-header">
                        公式
                    </div>
                    <input type="checkbox" id="add_official" class="add-special-input add-special" checked>
                </div>

                <div class="add-special-area">
                    <div class="add-special-header">
                        特典
                    </div>
                    <input type="checkbox" id="add_special" class="add-special-input add-special">
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
                            <input type="text" id="add_url_DVD" class="add-special-input add-special-input-text add-url-DVD">
                        </div>

                        <div class="add-url-DVD-movie-block add-url-movie-area">
                            <div class="add-url-DVD-movie-header add-url-movie-header">
                                ゲキ×シネ
                            </div>
                            <input type="text" id="add_url_movie" class="add-special-input add-special-input-text add-url-movie">
                        </div>
                    </div>
                </div>

                <div class="add-special-area">
                    <div class="add-special-header add-category-header">
                        カテゴリー
                    </div>
                    <select id="add_category" class="add-special-input add-special-input-text add-category">
                        <option value="1" selected>いのうえ歌舞伎</option>
                        <option value="2">ネタモノ</option>
                        <option value="3">音もの</option>
                        <option value="4">その他</option>
                    </select>
                </div>

                <div class="add-special-area">
                    <div class="add-special-header add-category-header">
                        貸し相手
                    </div>

                    <input type="text" id="add_rent" class="add-special-input add-special-input-text">
                </div>
            </div>
        </div>
        
        <!-- ボタン -->
        <div class="add-button-area">
            <button type="button" class="add-button add-back-button">
                <div class="add-button-icon">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </div>
            </button>

            <button type="submit" class="add-button add-submit-button" onclick="submitData()">
                <div class="add-button-icon">
                    送信
                </div>
            </button>
        </div>
    </main>

    <script src="../js/add.js"></script>
</body>
</html>