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

<body>
    <main class='add'>
        <div class='add-block'>
            <div class='add-block-1'>
                <!-- タイトル -->
                <div class='add-area add-title-area'>
                    <div class='add-header'>
                        タイトル
                    </div>
                    <input type='text' class='add-title' placeholder="タイトル">
                </div>

                <!-- 公演期間 -->
                <div class='add-area add-duration-area'>
                    <div class='add-header'>
                        公演期間
                    </div>
                    <div class='add-duration-input-area'>
                        <input type="date" value="2023-01-04" class='add-duration'> 
                        <div class='add-duration-conection'>
                            ~
                        </div>
                        <input type="date" value="2023-01-12" class='add-duration'> 
                    </div>
                </div>

                <!-- 公演場所 -->
                <div class='add-area add-location-area'>
                    <div class='add-header'>
                        公演場所
                    </div>
                    
                    <div class='add-locations-button-area'>
                        <div class='add-locations'>
                            <!-- 1セット -->
                            <div class='add-location'>
                                <select id='add_location_prefecture_select' class='add-location-prefecture'>
                                    <option hidden>選択</option>
                                </select>

                                <input type='text' class='add-location-theater'>
                            </div>
                        </div>

                        <!-- 増やすボタン -->
                        <div class='add-add-button-area'>
                            <button class='add-add-button'>
                                <div class='add-add-button-icon'>
                                    <i class='fa-solid fa-plus'></i>
                                </div>
                            </button>
                        </div>
                    </div>
                    
                </div>

                <!-- 感想 -->
                <div class='add-area add-impression-area'>
                    <div class='add-header'>
                        感想
                    </div>
                    <textarea class='add-impression' placeholder="どうだった？"></textarea>
                </div>

                <!-- あらすじ -->
                <div class='add-area add-story-area'>
                    <div class='add-header'>
                        あらすじ
                    </div>
                    <textarea class='add-story' placeholder="あらすじ"></textarea>
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
                                <div class='add-players-playerline'>
                                    <div class='add-players-cell add-players-line-cell add-players-cell-group'>
                                        <select id='add_players_group_select' class='add-players-input add-players-input-text add-players-group'>
                                            <option hidden>選択</option>
                                        </select>
                                    </div>
                                    <div class='add-players-cell add-players-line-cell add-players-cell-roll'>
                                        <input type='text' class='add-players-input add-players-input-text add-players-roll'>
                                    </div>
                                    <div class='add-players-cell add-players-line-cell add-players-cell-player'>
                                        <input type='text' class='add-players-input add-players-input-text add-players-player'>
                                    </div>
                                    <div class='add-players-cell add-players-line-cell add-players-cell-member'>
                                        <input type='checkbox' class='add-players-input add-players-member'>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- 増やすボタン -->
                            <div class='add-add-button-area'>
                                <button class='add-add-button'>
                                    <div class='add-add-button-icon'>
                                        <i class='fa-solid fa-plus'></i>
                                    </div>
                                </button>
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
                                <div class='add-groups-groupline'>
                                    <div class='add-groups-line-cell add-groups-cell-group'>
                                        <input type='text' class='add-groups-group'>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- 増やすボタン -->
                            <div class='add-add-button-area'>
                                <button class='add-add-button'>
                                    <div class='add-add-button-icon'>
                                        <i class='fa-solid fa-plus'></i>
                                    </div>
                                </button>
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
                        <div class='add-player-impressions-bodyline'>
                            <div class='add-players-impressions-cell add-player-impressions-body-cell add-player-impressions-cell-roll'>
                                <select id='add_player_impressions_roll_select' class='add-player-impressions-input add-player-impressions-roll'>
                                    <option hidden>選択</option>
                                </select>
                            </div>
                            <div class='add-players-impressions-cell add-player-impressions-body-cell add-player-impressions-cell-impression'>
                                <textarea class='add-player-impressions-input add-player-impressions-impression' placeholder="どうだった？"></textarea>  
                            </div>
                            <div class='add-players-impressions-cell add-player-impressions-body-cell add-player-impressions-cell-photo'>
                                <button id='add_player_impressions_photo_button' class='add-player-impressions-photo-button'>
                                    +選択
                                </button>
                                <input type='file' id='add_player_impressions_photo_input' class='add-player-impressions-photo' name="test" onchange="previewFile(this)">
                                
                                <img id="preview" class='add-player-impressions-photo-preview'>
                            </div>
                        </div>
                    </div>

                    <!-- 増やすボタン -->
                    <div class='add-add-button-area add-players-impressions-add-button-area'>
                        <button class='add-add-button'>
                            <div class='add-add-button-icon'>
                                <i class='fa-solid fa-plus'></i>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- 歴史 -->
                <div class='add-area add-story-area'>
                    <div class='add-header'>
                        歴史
                    </div>
                    <textarea class='add-story' placeholder="本当は？"></textarea>
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
                            <div class='add-others-bodyline'>
                                <div class='add-others-cell add-others-body-cell add-others-cell-title'>
                                    <input type='text' class='add-others-input add-others-title'>
                                </div>
                                <div class='add-others-cell add-others-body-cell add-others-cell-impression'>
                                    <textarea class='add-others-input add-others-impression' placeholder="どうだった？"></textarea>
                                </div>
                            </div>
                            
                        </div>

                        <!-- 増やすボタン -->
                        <div class='add-add-button-area'>
                            <button class='add-add-button'>
                                <div class='add-add-button-icon'>
                                    <i class='fa-solid fa-plus'></i>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class='add-block-2'>
                <div class='add-special-area'>
                    <div class='add-special-header'>
                        特典
                    </div>
                    <input type='checkbox' class='add-special-input add-special'>
                </div>

                <div class='add-special-area'>
                    <div class='add-special-header add-official-header'>
                        公式
                    </div>
                    <div class='add-official-DVD-movie-area'>
                        <div class='add-official-DVD-movie-block add-official-DVD-area'>
                            <div class='add-official-DVD-movie-header add-official-DVD-header'>
                                イーオシ
                            </div>
                            <input type='text' class='add-special-input add-special-input-text add-official-DVD'>
                        </div>

                        <div class='add-official-DVD-movie-block add-official-movie-area'>
                            <div class='add-official-DVD-movie-header add-official-movie-header'>
                                ゲキ×シネ
                            </div>
                            <input type='text' class='add-special-input add-special-input-text add-official-movie'>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ボタン -->
        <div class='add-button-area'>
                <button class='add-button add-back-button'>
                    <div class='add-button-icon'>
                        <i class='fa-solid fa-arrow-rotate-left'></i>
                    </div>
                </button>

                <button class='add-button add-submit-button'>
                    <div class='add-button-icon'>
                        送信
                    </div>
                </button>
            </div>
    </main>

    <script>
        function previewFile(hoge){
            var fileData = new FileReader();
            fileData.onload = (function() {
                //id属性が付与されているimgタグのsrc属性に、fileReaderで取得した値の結果を入力することで
                //プレビュー表示している
                document.getElementById('preview').src = fileData.result;
            });
            fileData.readAsDataURL(hoge.files[0]);
        }

        document.querySelector("#add_player_impressions_photo_button").addEventListener("click", () => {
            document.querySelector("#add_player_impressions_photo_input").click();
        });
    </script>
</body>
</html>