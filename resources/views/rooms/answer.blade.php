@extends('layouts.app')

@section('content')

<div class="ogiri-page room-answer-page">


<div class="room-answer-container">

    {{-- =========================
         ヘッダー
    ========================== --}}
    <div class="answer-header">

        <div>
            <div class="answer-label">
                🎮 PARTY MODE
            </div>

            <h1 class="answer-title">
                回答を投稿
            </h1>

            <p class="answer-subtitle">
                お題に合わせて、あなたの回答を投稿しよう！
            </p>
        </div>

        <a
            href="{{ route('rooms.show', $room) }}"
            class="back-button"
        >
            ← ルームに戻る
        </a>

    </div>


    {{-- =========================
         現在のお題
    ========================== --}}
    <section class="current-topic-card">

        <div class="section-label">
            📝 CURRENT TOPIC
        </div>

        @if($room->topic)

            <h2>
                {{ $room->topic->title }}
            </h2>

            @if($room->topic->description)

                <p>
                    {{ $room->topic->description }}
                </p>

            @endif

        @else

            <div class="no-topic">
                現在、お題が設定されていません。
            </div>

        @endif

    </section>


    {{-- =========================
         エラー
    ========================== --}}
    @if($errors->any())

        <div class="error-message">

            <strong>
                入力内容を確認してください
            </strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    {{-- =========================
         回答フォーム
    ========================== --}}
    <form
        action="{{ route('rooms.answer.store', $room) }}"
        method="POST"
        enctype="multipart/form-data"
        id="roomAnswerForm"
    >

        @csrf


        {{-- =========================
             回答形式
        ========================== --}}
        <section class="answer-form-card">

            <div class="section-label">
                ✏️ ANSWER TYPE
            </div>

            <h2 class="form-title">
                回答方法を選択
            </h2>

            <div class="answer-type-list">

                <label class="type-option">

                    <input
                        type="radio"
                        name="answer_type"
                        value="text"
                        checked
                    >

                    <span class="type-icon">
                        ✏️
                    </span>

                    <span>
                        <strong>テキスト</strong>
                        <small>文章で回答する</small>
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

                    <span>
                        <strong>イラスト</strong>
                        <small>絵を描いて回答する</small>
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

                    <span>
                        <strong>画像</strong>
                        <small>画像をアップロードする</small>
                    </span>

                </label>

            </div>


            {{-- =========================
                 テキスト
            ========================== --}}
            <div
                id="textArea"
                class="answer-area active"
            >

                <label class="input-label">
                    回答
                </label>

                <textarea
                    name="content"
                    class="answer-textarea"
                    placeholder="お題への回答を入力してください"
                    maxlength="1000"
                >{{ old('content') }}</textarea>

                <div class="character-limit">
                    最大1000文字
                </div>

            </div>


            {{-- =========================
                 イラスト
            ========================== --}}
            <div
                id="drawingArea"
                class="answer-area"
            >

                <label class="input-label">
                    イラストを描く
                </label>

                <div class="canvas-wrapper">

                    <canvas
                        id="drawingCanvas"
                        width="1000"
                        height="600"
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


            {{-- =========================
                 画像
            ========================== --}}
            <div
                id="imageArea"
                class="answer-area"
            >

                <label class="input-label">
                    画像をアップロード
                </label>

                <div class="image-upload-area">

                    <input
                        type="file"
                        name="image"
                        id="imageInput"
                        accept="image/*"
                        class="image-input"
                    >

                    <label
                        for="imageInput"
                        class="image-upload-label"
                    >
                        <span class="upload-icon">
                            🖼️
                        </span>

                        <strong>
                            画像を選択
                        </strong>

                        <small>
                            JPG・PNG・GIF・WEBP
                        </small>
                    </label>

                </div>

                <div
                    id="imagePreviewArea"
                    class="image-preview-area"
                >
                    <img
                        id="imagePreview"
                        src=""
                        alt="画像プレビュー"
                    >
                </div>

            </div>


            {{-- =========================
                 補足説明
            ========================== --}}
            <div class="description-area">

                <label class="input-label">
                    💡 補足説明
                    <span>任意</span>
                </label>

                <textarea
                    name="description"
                    class="description-textarea"
                    placeholder="回答についての補足や説明があれば入力してください"
                    maxlength="500"
                >{{ old('description') }}</textarea>

                <div class="character-limit">
                    最大500文字
                </div>

            </div>

        </section>


        {{-- =========================
             ボタン
        ========================== --}}
        <div class="form-actions">

            <a
                href="{{ route('rooms.show', $room) }}"
                class="cancel-button"
            >
                キャンセル
            </a>

            <button
                type="submit"
                class="submit-button"
            >
                🎉 回答を投稿する
            </button>

        </div>

    </form>

</div>



</div>

<style>

/* =========================
   ページ
========================= */

.room-answer-page {
    min-height: calc(100vh - 64px);

    background:
        radial-gradient(
            circle at top left,
            rgba(168, 85, 247, 0.12),
            transparent 35%
        ),
        radial-gradient(
            circle at bottom right,
            rgba(236, 72, 153, 0.12),
            transparent 35%
        ),
        linear-gradient(
            135deg,
            #faf5ff,
            #ffffff,
            #fdf2f8
        );
}

.room-answer-container {
    width: 100%;
    max-width: 1200px;

    margin: 0 auto;
}


/* =========================
   ヘッダー
========================= */

.answer-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 40px;

    margin-bottom: 40px;
}

.answer-label {
    display: inline-block;

    margin-bottom: 12px;
    padding: 8px 18px;

    border-radius: 999px;

    background: #ede9fe;

    color: #7c3aed;

    font-size: 15px;
    font-weight: 900;

    letter-spacing: 0.08em;
}

.answer-title {
    margin: 0;

    color: #4c1d95;

    font-size: 46px;
    line-height: 1.25;

    font-weight: 900;
}

.answer-subtitle {
    margin-top: 12px;

    color: #64748b;

    font-size: 18px;
}

.back-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 50px;

    padding: 0 22px;

    border-radius: 12px;

    background: white;

    border: 1px solid #ddd6fe;

    color: #6d28d9;

    font-size: 15px;
    font-weight: 800;

    text-decoration: none;
}


/* =========================
   お題
========================= */

.current-topic-card {
    margin-bottom: 28px;

    padding: 35px;

    border-radius: 24px;

    background: white;

    border: 1px solid #e9d5ff;

    box-shadow:
        0 12px 35px rgba(76, 29, 149, 0.08);
}

.section-label {
    margin-bottom: 12px;

    color: #7c3aed;

    font-size: 13px;
    font-weight: 900;

    letter-spacing: 0.08em;
}

.current-topic-card h2 {
    margin: 0;

    color: #312e81;

    font-size: 38px;
    line-height: 1.4;

    font-weight: 900;
}

.current-topic-card p {
    margin-top: 18px;

    color: #64748b;

    font-size: 17px;
    line-height: 1.8;

    white-space: pre-wrap;
}

.no-topic {
    padding: 20px;

    border-radius: 12px;

    background: #fef2f2;

    color: #b91c1c;

    font-weight: 700;
}


/* =========================
   エラー
========================= */

.error-message {
    margin-bottom: 28px;

    padding: 20px 24px;

    border-radius: 14px;

    background: #fef2f2;

    border: 1px solid #fecaca;

    color: #b91c1c;
}

.error-message ul {
    margin-top: 8px;
}


/* =========================
   フォームカード
========================= */

.answer-form-card {
    padding: 38px;

    border-radius: 24px;

    background: white;

    border: 1px solid #e9d5ff;

    box-shadow:
        0 12px 35px rgba(76, 29, 149, 0.08);
}

.form-title {
    margin: 0 0 25px;

    color: #312e81;

    font-size: 28px;
    font-weight: 900;
}


/* =========================
   回答形式
========================= */

.answer-type-list {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 18px;

    margin-bottom: 35px;
}

.type-option {
    display: flex;
    align-items: center;

    gap: 14px;

    min-height: 95px;

    padding: 18px 20px;

    border-radius: 16px;

    background: #faf5ff;

    border: 2px solid #ede9fe;

    cursor: pointer;

    transition:
        background 0.2s ease,
        border-color 0.2s ease,
        transform 0.2s ease;
}

.type-option:hover {
    transform: translateY(-2px);

    border-color: #c4b5fd;
}

.type-option:has(input:checked) {
    background: #f3e8ff;

    border-color: #8b5cf6;
}

.type-option input {
    width: 18px;
    height: 18px;

    accent-color: #7c3aed;
}

.type-icon {
    font-size: 30px;
}

.type-option strong {
    display: block;

    color: #312e81;

    font-size: 17px;
}

.type-option small {
    display: block;

    margin-top: 4px;

    color: #64748b;

    font-size: 13px;
}


/* =========================
   回答エリア
========================= */

.answer-area {
    display: none;
}

.answer-area.active {
    display: block;
}

.input-label {
    display: block;

    margin-bottom: 10px;

    color: #312e81;

    font-size: 16px;
    font-weight: 800;
}


/* =========================
   テキスト
========================= */

.answer-textarea {
    width: 100%;

    min-height: 300px;

    padding: 20px;

    border-radius: 16px;

    border: 1px solid #ddd6fe;

    background: #fafafa;

    color: #1e1b4b;

    font-size: 20px;
    line-height: 1.7;

    resize: vertical;

    outline: none;
}

.answer-textarea:focus,
.description-textarea:focus {
    border-color: #8b5cf6;

    box-shadow:
        0 0 0 3px rgba(139, 92, 246, 0.12);
}

.character-limit {
    margin-top: 7px;

    text-align: right;

    color: #94a3b8;

    font-size: 13px;
}


/* =========================
   キャンバス
========================= */

.canvas-wrapper {
    width: 100%;

    padding: 12px;

    border-radius: 18px;

    background: #f8fafc;

    border: 1px solid #ddd6fe;

    overflow-x: auto;
}

#drawingCanvas {
    display: block;

    width: 100%;
    max-width: 1000px;

    height: auto;

    margin: 0 auto;

    background: white;

    border-radius: 10px;

    cursor: crosshair;
}

.clear-button {
    margin-top: 14px;

    min-height: 45px;

    padding: 0 18px;

    border: 0;

    border-radius: 10px;

    background: #f1f5f9;

    color: #475569;

    font-size: 14px;
    font-weight: 800;

    cursor: pointer;
}


/* =========================
   画像
========================= */

.image-upload-area {
    width: 100%;
}

.image-input {
    display: none;
}

.image-upload-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    min-height: 260px;

    padding: 30px;

    border-radius: 18px;

    border: 2px dashed #c4b5fd;

    background: #faf5ff;

    color: #6d28d9;

    cursor: pointer;

    transition: background 0.2s ease;
}

.image-upload-label:hover {
    background: #f3e8ff;
}

.upload-icon {
    margin-bottom: 12px;

    font-size: 52px;
}

.image-upload-label strong {
    font-size: 18px;
}

.image-upload-label small {
    margin-top: 7px;

    color: #64748b;
}

.image-preview-area {
    display: none;

    margin-top: 20px;

    padding: 15px;

    border-radius: 16px;

    background: #f8fafc;

    border: 1px solid #e2e8f0;
}

.image-preview-area.show {
    display: block;
}

.image-preview-area img {
    display: block;

    max-width: 100%;
    max-height: 500px;

    margin: 0 auto;

    border-radius: 12px;
}


/* =========================
   補足説明
========================= */

.description-area {
    margin-top: 35px;

    padding-top: 30px;

    border-top: 1px solid #e2e8f0;
}

.input-label span {
    margin-left: 8px;

    padding: 3px 8px;

    border-radius: 999px;

    background: #f1f5f9;

    color: #64748b;

    font-size: 11px;
}

.description-textarea {
    width: 100%;

    min-height: 150px;

    padding: 18px;

    border-radius: 14px;

    border: 1px solid #ddd6fe;

    background: #fafafa;

    color: #1e1b4b;

    font-size: 16px;

    line-height: 1.7;

    resize: vertical;

    outline: none;
}


/* =========================
   ボタン
========================= */

.form-actions {
    display: flex;
    justify-content: flex-end;

    gap: 15px;

    margin-top: 28px;
}

.cancel-button,
.submit-button {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    min-height: 56px;

    padding: 0 30px;

    border-radius: 13px;

    font-size: 16px;
    font-weight: 900;

    text-decoration: none;

    cursor: pointer;
}

.cancel-button {
    background: white;

    border: 1px solid #cbd5e1;

    color: #64748b;
}

.submit-button {
    border: 0;

    background:
        linear-gradient(
            135deg,
            #7c3aed,
            #ec4899
        );

    color: white;

    box-shadow:
        0 10px 25px rgba(124, 58, 237, 0.22);
}


/* =========================
   大画面
========================= */

@media (min-width: 1536px) {

    .room-answer-container {
        max-width: 1300px;
    }

    .answer-title {
        font-size: 52px;
    }

    .current-topic-card h2 {
        font-size: 42px;
    }

    .answer-form-card {
        padding: 45px;
    }

}


/* =========================
   タブレット
========================= */

@media (max-width: 900px) {

    .answer-type-list {
        grid-template-columns: 1fr;
    }

}


/* =========================
   スマートフォン
========================= */

@media (max-width: 700px) {

    .answer-header {
        flex-direction: column;
        align-items: stretch;
    }

    .answer-title {
        font-size: 34px;
    }

    .back-button {
        width: 100%;
    }

    .current-topic-card,
    .answer-form-card {
        padding: 22px;

        border-radius: 18px;
    }

    .current-topic-card h2 {
        font-size: 28px;
    }

    .answer-textarea {
        min-height: 240px;

        font-size: 17px;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .cancel-button,
    .submit-button {
        width: 100%;
    }

}

</style>

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =========================
       回答形式切り替え
    ========================== */

    const typeRadios =
        document.querySelectorAll(
            'input[name="answer_type"]'
        );

    const textArea =
        document.getElementById('textArea');

    const drawingArea =
        document.getElementById('drawingArea');

    const imageArea =
        document.getElementById('imageArea');


    function switchAnswerType(type) {

        textArea.classList.remove('active');
        drawingArea.classList.remove('active');
        imageArea.classList.remove('active');

        if (type === 'text') {
            textArea.classList.add('active');
        }

        if (type === 'drawing') {
            drawingArea.classList.add('active');
        }

        if (type === 'image') {
            imageArea.classList.add('active');
        }

    }


    typeRadios.forEach(function (radio) {

        radio.addEventListener(
            'change',
            function () {

                switchAnswerType(
                    this.value
                );

            }
        );

    });


    /* =========================
       キャンバス
    ========================== */

    const canvas =
        document.getElementById('drawingCanvas');

    const ctx =
        canvas.getContext('2d');

    let drawing = false;


    ctx.fillStyle = '#ffffff';

    ctx.fillRect(
        0,
        0,
        canvas.width,
        canvas.height
    );


    function getPosition(event) {

        const rect =
            canvas.getBoundingClientRect();

        const scaleX =
            canvas.width / rect.width;

        const scaleY =
            canvas.height / rect.height;

        let clientX;
        let clientY;

        if (event.touches) {

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
            x: (clientX - rect.left) * scaleX,
            y: (clientY - rect.top) * scaleY
        };

    }


    function startDrawing(event) {

        event.preventDefault();

        drawing = true;

        const pos =
            getPosition(event);

        ctx.beginPath();

        ctx.moveTo(
            pos.x,
            pos.y
        );

    }


    function draw(event) {

        if (!drawing) return;

        event.preventDefault();

        const pos =
            getPosition(event);

        ctx.lineWidth = 5;

        ctx.lineCap = 'round';

        ctx.lineJoin = 'round';

        ctx.strokeStyle = '#312e81';

        ctx.lineTo(
            pos.x,
            pos.y
        );

        ctx.stroke();

    }


    function stopDrawing() {

        drawing = false;

        ctx.closePath();

    }


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


    /* =========================
       キャンバスクリア
    ========================== */

    const clearCanvas =
        document.getElementById('clearCanvas');

    clearCanvas.addEventListener(
        'click',
        function () {

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


    /* =========================
       画像プレビュー
    ========================== */

    const imageInput =
        document.getElementById('imageInput');

    const imagePreview =
        document.getElementById('imagePreview');

    const imagePreviewArea =
        document.getElementById(
            'imagePreviewArea'
        );


    imageInput.addEventListener(
        'change',
        function () {

            const file =
                this.files[0];

            if (!file) {

                imagePreviewArea.classList.remove(
                    'show'
                );

                return;

            }


            const reader =
                new FileReader();


            reader.onload =
                function (event) {

                    imagePreview.src =
                        event.target.result;

                    imagePreviewArea.classList.add(
                        'show'
                    );

                };


            reader.readAsDataURL(file);

        }
    );


    /* =========================
       投稿時
    ========================== */

    const form =
        document.getElementById(
            'roomAnswerForm'
        );

    const drawingData =
        document.getElementById(
            'drawingData'
        );


    form.addEventListener(
        'submit',
        function () {

            const selected =
                document.querySelector(
                    'input[name="answer_type"]:checked'
                );

            if (
                selected &&
                selected.value === 'drawing'
            ) {

                drawingData.value =
                    canvas.toDataURL(
                        'image/png'
                    );

            }

        }
    );

});

</script>

@endsection
