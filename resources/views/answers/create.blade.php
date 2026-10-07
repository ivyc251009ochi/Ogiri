@extends('layouts.app')

@section('content')

<div class="answer-create-page">

    {{-- ========================================
         ヘッダー
    ======================================== --}}

    <div class="answer-header">

        <div>

            <div class="answer-label">
                ✏️ POST MODE
            </div>

            <h1>
                回答を投稿
            </h1>

            <p>
                お題に合わせて、あなたの回答を投稿しましょう！
            </p>

        </div>


        <a
            href="{{ route('topics.show', $topic) }}"
            class="back-button"
        >
            ← お題に戻る
        </a>

    </div>


    {{-- ========================================
         お題
    ======================================== --}}

    <section class="question-card">

        <div class="question-label">
            🎯 CURRENT TOPIC
        </div>


        <h2>
            {{ $topic->title }}
        </h2>


        @if($topic->description)

            <p>
                {{ $topic->description }}
            </p>

        @endif

    </section>


    {{-- ========================================
         エラーメッセージ
    ======================================== --}}

    @if($errors->any())

        <div class="error-message">

            <div class="error-title">
                ⚠️ 入力内容を確認してください
            </div>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ========================================
         回答フォーム
    ======================================== --}}

    <form
        method="POST"
        action="{{ route('answers.store') }}"
        enctype="multipart/form-data"
        id="answerForm"
    >

        @csrf


        {{-- お題ID --}}

        <input
            type="hidden"
            name="topic_id"
            value="{{ $topic->id }}"
        >


        {{-- ====================================
             回答方法
        ==================================== --}}

        <section class="answer-panel">

            <div class="panel-title">

                <span class="panel-icon">
                    ✏️
                </span>

                <div>

                    <span class="panel-label">
                        ANSWER TYPE
                    </span>

                    <h2>
                        回答方法を選択
                    </h2>

                </div>

            </div>


            {{-- ==================================
                 回答タイプ選択
            ================================== --}}

            <div class="answer-type-selector">

                <label class="type-option active">

                    <input
                        type="radio"
                        name="answer_type"
                        value="text"
                        checked
                    >

                    <span class="type-icon">
                        ✏️
                    </span>

                    <span class="type-name">
                        テキスト
                    </span>

                    <span class="type-description">
                        文章で回答
                    </span>

                </label>


                <label class="type-option">

                    <input
                        type="radio"
                        name="answer_type"
                        value="drawing"
                    >

                    <span class="type-icon">
                        🎨
                    </span>

                    <span class="type-name">
                        イラスト
                    </span>

                    <span class="type-description">
                        絵を描いて回答
                    </span>

                </label>


                <label class="type-option">

                    <input
                        type="radio"
                        name="answer_type"
                        value="image"
                    >

                    <span class="type-icon">
                        🖼️
                    </span>

                    <span class="type-name">
                        画像
                    </span>

                    <span class="type-description">
                        画像を使って回答
                    </span>

                </label>

            </div>


            {{-- ==================================
                 テキスト回答
            ================================== --}}

            <div
                id="textArea"
                class="answer-area active"
            >

                <label
                    for="content"
                    class="input-label"
                >
                    💬 回答内容
                </label>


                <textarea
                    id="content"
                    name="content"
                    rows="8"
                    maxlength="1000"
                    placeholder="ここに面白い回答を入力してください！"
                >{{ old('content') }}</textarea>


                <div class="input-help">
                    最大1000文字まで入力できます。
                </div>

            </div>


            {{-- ==================================
                 イラスト回答
            ================================== --}}

            <div
                id="drawingArea"
                class="answer-area"
            >

                <label class="input-label">
                    🎨 イラストを描く
                </label>


                <p class="drawing-help">
                    マウスでキャンバスに自由に絵を描いてください。
                </p>


                <div class="canvas-wrapper">

                    <canvas
                        id="drawingCanvas"
                        width="900"
                        height="500"
                    ></canvas>

                </div>


                <input
                    type="hidden"
                    name="drawing_data"
                    id="drawingData"
                >


                <button
                    type="button"
                    id="clearCanvas"
                    class="clear-button"
                >
                    🗑️ キャンバスをクリア
                </button>

            </div>


            {{-- ==================================
                 画像回答
            ================================== --}}

            <div
                id="imageArea"
                class="answer-area"
            >

                <label
                    for="image"
                    class="input-label"
                >
                    🖼️ 画像を選択
                </label>


                <div class="file-area">

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/*"
                    >


                    <p>
                        JPG・JPEG・PNG・GIF・WEBPに対応しています。
                    </p>

                </div>


                <div
                    id="imagePreview"
                    class="image-preview"
                >

                    <span>
                        画像を選択するとここに表示されます
                    </span>

                </div>

            </div>


            {{-- ==================================
                 補足説明
            ================================== --}}

            <div class="description-area">

                <label
                    for="description"
                    class="input-label"
                >
                    💡 補足説明

                    <span class="optional">
                        任意
                    </span>

                </label>


                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    maxlength="500"
                    placeholder="回答についての補足や、面白さのポイントなどがあれば入力してください。"
                >{{ old('description') }}</textarea>


                <div class="input-help">
                    最大500文字まで入力できます。
                </div>

            </div>


            {{-- ==================================
                 投稿ボタン
            ================================== --}}

            <div class="submit-area">

                <a
                    href="{{ route('topics.show', $topic) }}"
                    class="cancel-button"
                >
                    キャンセル
                </a>


                <button
                    type="submit"
                    class="submit-button"
                >
                    🚀 回答を投稿する
                </button>

            </div>

        </section>

    </form>

</div>


<style>

/* ========================================
   ページ全体
======================================== */

.answer-create-page {

    width: 100%;

    min-height: calc(100vh - 80px);

    padding: 55px 50px 100px;

    box-sizing: border-box;

    background:
        linear-gradient(
            135deg,
            #f5f3ff 0%,
            #ffffff 45%,
            #fff1f7 100%
        );

    color: #173f70;
}


/* ========================================
   ヘッダー
======================================== */

.answer-header {

    width: 100%;

    max-width: 1350px;

    margin: 0 auto 30px;

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 30px;
}


.answer-label {

    margin-bottom: 7px;

    color: #8b5cf6;

    font-size: 13px;

    font-weight: 800;

    letter-spacing: 2px;
}


.answer-header h1 {

    margin: 0;

    color: #173f70;

    font-size: 45px;

    font-weight: 800;

    line-height: 1.25;
}


.answer-header p {

    margin: 10px 0 0;

    color: #718096;

    font-size: 17px;
}


/* ========================================
   戻る
======================================== */

.back-button {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 50px;

    padding: 12px 22px;

    box-sizing: border-box;

    background: #e7edf6;

    color: #31506f !important;

    text-decoration: none;

    border-radius: 12px;

    font-size: 16px;

    font-weight: 700;

    white-space: nowrap;

    transition: 0.2s;
}


.back-button:hover {

    background: #dce5f2;

    transform: translateY(-2px);
}


/* ========================================
   お題カード
======================================== */

.question-card {

    width: 100%;

    max-width: 1350px;

    margin: 0 auto 30px;

    padding: 38px 50px;

    box-sizing: border-box;

    text-align: center;

    background:
        linear-gradient(
            135deg,
            #ede9fe,
            #fdf2f8
        );

    border: 2px solid #ddd6fe;

    border-radius: 22px;

    box-shadow:
        0 10px 28px
        rgba(40,60,110,0.08);
}


.question-label {

    margin-bottom: 12px;

    color: #8b5cf6;

    font-size: 12px;

    font-weight: 800;

    letter-spacing: 2px;
}


.question-card h2 {

    margin: 0;

    color: #173f70;

    font-size: 38px;

    line-height: 1.45;

    font-weight: 800;
}


.question-card p {

    max-width: 900px;

    margin: 14px auto 0;

    color: #64748b;

    font-size: 16px;

    line-height: 1.8;
}


/* ========================================
   エラー
======================================== */

.error-message {

    width: 100%;

    max-width: 1350px;

    margin: 0 auto 25px;

    padding: 20px 25px;

    box-sizing: border-box;

    background: #fff1f2;

    border: 2px solid #fda4af;

    border-radius: 15px;

    color: #9f1239;
}


.error-title {

    margin-bottom: 8px;

    font-weight: 800;
}


.error-message ul {

    margin: 0;

    padding-left: 22px;
}


/* ========================================
   回答パネル
======================================== */

.answer-panel {

    width: 100%;

    max-width: 1350px;

    margin: 0 auto;

    padding: 38px 45px;

    box-sizing: border-box;

    background: #ffffff;

    border-radius: 24px;

    box-shadow:
        0 12px 35px
        rgba(40,60,110,0.10);
}


/* ========================================
   パネルタイトル
======================================== */

.panel-title {

    display: flex;

    align-items: center;

    gap: 18px;

    margin-bottom: 28px;
}


.panel-icon {

    display: flex;

    align-items: center;

    justify-content: center;

    width: 60px;

    height: 60px;

    flex-shrink: 0;

    background: #ede9fe;

    border-radius: 17px;

    font-size: 29px;
}


.panel-label {

    display: block;

    margin-bottom: 4px;

    color: #8b5cf6;

    font-size: 11px;

    font-weight: 800;

    letter-spacing: 1.8px;
}


.panel-title h2 {

    margin: 0;

    color: #173f70;

    font-size: 25px;

    font-weight: 800;
}


/* ========================================
   回答タイプ
======================================== */

.answer-type-selector {

    display: grid;

    grid-template-columns: repeat(3, 1fr);

    gap: 20px;

    margin-bottom: 30px;
}


.type-option {

    position: relative;

    min-height: 145px;

    padding: 22px;

    box-sizing: border-box;

    display: flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    text-align: center;

    border: 2px solid #e2e8f0;

    border-radius: 17px;

    background: #ffffff;

    cursor: pointer;

    transition: 0.2s;
}


.type-option:hover {

    border-color: #c4b5fd;

    background: #faf9ff;
}


.type-option.active {

    border-color: #8b5cf6;

    background:
        linear-gradient(
            135deg,
            #f5f3ff,
            #fdf2f8
        );

    box-shadow:
        0 7px 18px
        rgba(139,92,246,0.12);
}


.type-option input {

    position: absolute;

    opacity: 0;

    pointer-events: none;
}


.type-icon {

    margin-bottom: 8px;

    font-size: 36px;
}


.type-name {

    color: #173f70;

    font-size: 18px;

    font-weight: 800;
}


.type-description {

    margin-top: 4px;

    color: #94a3b8;

    font-size: 13px;
}


/* ========================================
   回答入力エリア
======================================== */

.answer-area {

    display: none;

    padding: 30px;

    margin-bottom: 25px;

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    border-radius: 18px;
}


.answer-area.active {

    display: block;
}


/* ========================================
   入力ラベル
======================================== */

.input-label {

    display: flex;

    align-items: center;

    gap: 8px;

    margin-bottom: 12px;

    color: #31506f;

    font-size: 17px;

    font-weight: 800;
}


/* ========================================
   テキストエリア
======================================== */

.answer-area textarea,
.description-area textarea {

    width: 100%;

    padding: 18px;

    box-sizing: border-box;

    border: 2px solid #dbe3ef;

    border-radius: 13px;

    background: #ffffff;

    color: #243b53;

    font-size: 17px;

    line-height: 1.7;

    outline: none;

    resize: vertical;

    transition: 0.2s;
}


.answer-area textarea:focus,
.description-area textarea:focus {

    border-color: #8b5cf6;

    box-shadow:
        0 0 0 3px
        rgba(139,92,246,0.10);
}


.input-help {

    margin-top: 8px;

    color: #94a3b8;

    font-size: 12px;
}


/* ========================================
   イラスト
======================================== */

.drawing-help {

    margin: -5px 0 15px;

    color: #718096;

    font-size: 14px;
}


.canvas-wrapper {

    width: 100%;

    overflow: hidden;

    border: 2px solid #dbe3ef;

    border-radius: 15px;

    background: #ffffff;
}


#drawingCanvas {

    display: block;

    width: 100%;

    height: auto;

    cursor: crosshair;

    touch-action: none;
}


.clear-button {

    margin-top: 13px;

    padding: 10px 17px;

    border: none;

    border-radius: 10px;

    background: #e2e8f0;

    color: #475569;

    font-size: 14px;

    font-weight: 700;

    cursor: pointer;

    transition: 0.2s;
}


.clear-button:hover {

    background: #cbd5e1;
}


/* ========================================
   画像
======================================== */

.file-area {

    padding: 25px;

    text-align: center;

    border: 2px dashed #cbd5e1;

    border-radius: 15px;

    background: #ffffff;
}


.file-area input {

    width: 100%;

    max-width: 600px;

    font-size: 15px;
}


.file-area p {

    margin: 12px 0 0;

    color: #94a3b8;

    font-size: 13px;
}


.image-preview {

    min-height: 230px;

    margin-top: 18px;

    display: flex;

    align-items: center;

    justify-content: center;

    overflow: hidden;

    border: 1px solid #e2e8f0;

    border-radius: 15px;

    background: #ffffff;

    color: #94a3b8;

    font-size: 14px;
}


.image-preview img {

    display: block;

    max-width: 100%;

    max-height: 500px;

    object-fit: contain;
}


/* ========================================
   補足説明
======================================== */

.description-area {

    padding: 30px;

    margin-bottom: 30px;

    background: #fffaf2;

    border: 1px solid #fed7aa;

    border-radius: 18px;
}


.optional {

    display: inline-flex;

    padding: 3px 8px;

    margin-left: 5px;

    border-radius: 6px;

    background: #fef3c7;

    color: #a16207;

    font-size: 11px;

    font-weight: 700;
}


/* ========================================
   投稿ボタン
======================================== */

.submit-area {

    display: flex;

    justify-content: flex-end;

    align-items: center;

    gap: 15px;
}


.cancel-button {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 55px;

    padding: 13px 26px;

    background: #e7edf6;

    color: #31506f !important;

    text-decoration: none;

    border-radius: 13px;

    font-size: 16px;

    font-weight: 700;

    transition: 0.2s;
}


.cancel-button:hover {

    background: #dce5f2;
}


.submit-button {

    min-width: 220px;

    min-height: 55px;

    padding: 13px 30px;

    border: none;

    border-radius: 13px;

    background:
        linear-gradient(
            135deg,
            #ff4f87,
            #ff3978
        );

    color: #ffffff;

    font-size: 17px;

    font-weight: 800;

    cursor: pointer;

    box-shadow:
        0 9px 20px
        rgba(255,79,135,0.22);

    transition: 0.2s;
}


.submit-button:hover {

    transform: translateY(-3px);

    filter: brightness(1.06);

    box-shadow:
        0 13px 27px
        rgba(255,79,135,0.30);
}


/* ========================================
   1536px以上
======================================== */

@media (min-width: 1536px) {

    .answer-create-page {

        padding-left: 70px;

        padding-right: 70px;
    }


    .answer-header,
    .question-card,
    .answer-panel,
    .error-message {

        max-width: 1450px;
    }


    .question-card {

        padding: 45px 60px;
    }


    .question-card h2 {

        font-size: 42px;
    }


    .answer-panel {

        padding: 45px 55px;
    }


    .type-option {

        min-height: 160px;
    }

}


/* ========================================
   900px以下
======================================== */

@media (max-width: 900px) {

    .answer-create-page {

        padding: 40px 25px 80px;
    }


    .answer-header {

        align-items: flex-start;

        flex-direction: column;
    }


    .back-button {

        width: 100%;
    }


    .answer-type-selector {

        grid-template-columns: 1fr;
    }


    .type-option {

        min-height: 110px;
    }

}


/* ========================================
   スマートフォン
======================================== */

@media (max-width: 600px) {

    .answer-create-page {

        padding: 25px 13px 60px;
    }


    .answer-header h1 {

        font-size: 32px;
    }


    .answer-header p {

        font-size: 14px;
    }


    .question-card {

        padding: 28px 18px;
    }


    .question-card h2 {

        font-size: 27px;
    }


    .answer-panel {

        padding: 25px 18px;

        border-radius: 20px;
    }


    .answer-area,
    .description-area {

        padding: 20px;
    }


    .submit-area {

        flex-direction: column-reverse;

        align-items: stretch;
    }


    .cancel-button,
    .submit-button {

        width: 100%;
    }

}

</style>


<script>

/* ========================================
   回答タイプ切り替え
======================================== */

const typeOptions =
    document.querySelectorAll('.type-option');

const answerTypes =
    document.querySelectorAll(
        'input[name="answer_type"]'
    );

const textArea =
    document.getElementById('textArea');

const drawingArea =
    document.getElementById('drawingArea');

const imageArea =
    document.getElementById('imageArea');


function updateAnswerType() {

    const selected =
        document.querySelector(
            'input[name="answer_type"]:checked'
        );


    if (!selected) {

        return;

    }


    const type =
        selected.value;


    /* 全て非表示 */

    textArea.classList.remove('active');

    drawingArea.classList.remove('active');

    imageArea.classList.remove('active');


    /* 選択したものだけ表示 */

    if (type === 'text') {

        textArea.classList.add('active');

    }


    if (type === 'drawing') {

        drawingArea.classList.add('active');

    }


    if (type === 'image') {

        imageArea.classList.add('active');

    }


    /* 選択状態 */

    typeOptions.forEach(option => {

        option.classList.remove('active');

    });


    selected
        .closest('.type-option')
        .classList.add('active');

}


/* ラジオボタン */

answerTypes.forEach(input => {

    input.addEventListener(
        'change',
        updateAnswerType
    );

});


/* 初期状態 */

updateAnswerType();


/* ========================================
   キャンバス
======================================== */

const canvas =
    document.getElementById('drawingCanvas');

const ctx =
    canvas.getContext('2d');

const drawingData =
    document.getElementById('drawingData');

let drawing = false;


/* 白背景 */

ctx.fillStyle = '#ffffff';

ctx.fillRect(
    0,
    0,
    canvas.width,
    canvas.height
);


/* 線 */

ctx.lineWidth = 5;

ctx.lineCap = 'round';

ctx.lineJoin = 'round';

ctx.strokeStyle = '#173f70';


function getPosition(event) {

    const rect =
        canvas.getBoundingClientRect();


    const scaleX =
        canvas.width / rect.width;

    const scaleY =
        canvas.height / rect.height;


    let clientX;

    let clientY;


    if (
        event.touches &&
        event.touches.length > 0
    ) {

        clientX =
            event.touches[0].clientX;

        clientY =
            event.touches[0].clientY;

    } else {

        clientX =
            event.clientX;

        clientY =
            event.clientY;

    }


    return {

        x:
            (clientX - rect.left)
            * scaleX,

        y:
            (clientY - rect.top)
            * scaleY

    };

}


/* ========================================
   描画開始
======================================== */

function startDrawing(event) {

    event.preventDefault();

    drawing = true;


    const position =
        getPosition(event);


    ctx.beginPath();


    ctx.moveTo(
        position.x,
        position.y
    );

}


/* ========================================
   描画
======================================== */

function draw(event) {

    if (!drawing) {

        return;

    }


    event.preventDefault();


    const position =
        getPosition(event);


    ctx.lineTo(
        position.x,
        position.y
    );


    ctx.stroke();

}


/* ========================================
   描画終了
======================================== */

function stopDrawing() {

    if (!drawing) {

        return;

    }


    drawing = false;

    ctx.closePath();

}


/* マウス */

canvas.addEventListener(
    'mousedown',
    startDrawing
);

canvas.addEventListener(
    'mousemove',
    draw
);

canvas.addEventListener(
    'mouseup',
    stopDrawing
);

canvas.addEventListener(
    'mouseleave',
    stopDrawing
);


/* タッチ */

canvas.addEventListener(
    'touchstart',
    startDrawing,
    { passive: false }
);

canvas.addEventListener(
    'touchmove',
    draw,
    { passive: false }
);

canvas.addEventListener(
    'touchend',
    stopDrawing
);


/* ========================================
   キャンバスクリア
======================================== */

const clearCanvas =
    document.getElementById('clearCanvas');


clearCanvas.addEventListener(
    'click',
    function() {

        ctx.clearRect(
            0,
            0,
            canvas.width,
            canvas.height
        );


        ctx.fillStyle = '#ffffff';


        ctx.fillRect(
            0,
            0,
            canvas.width,
            canvas.height
        );

    }
);


/* ========================================
   画像プレビュー
======================================== */

const imageInput =
    document.getElementById('image');

const imagePreview =
    document.getElementById('imagePreview');


imageInput.addEventListener(
    'change',
    function() {

        const file =
            this.files[0];


        if (!file) {

            imagePreview.innerHTML =
                '<span>画像を選択するとここに表示されます</span>';

            return;

        }


        const reader =
            new FileReader();


        reader.onload =
            function(event) {

                imagePreview.innerHTML =
                    `<img
                        src="${event.target.result}"
                        alt="画像プレビュー"
                    >`;

            };


        reader.readAsDataURL(file);

    }
);


/* ========================================
   フォーム送信
======================================== */

const answerForm =
    document.getElementById('answerForm');


answerForm.addEventListener(
    'submit',
    function() {

        const selected =
            document.querySelector(
                'input[name="answer_type"]:checked'
            );


        /* イラストの場合 */

        if (
            selected &&
            selected.value === 'drawing'
        ) {

            drawingData.value =
                canvas.toDataURL('image/png');

        }

    }
);

</script>

@endsection