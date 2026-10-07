@extends('layouts.app')

@section('content')

<div class="topic-create-container">

    <h1>📝 お題を作成</h1>

    <p class="description">
        みんなが楽しめる大喜利のお題を作成しましょう！
    </p>

    <form action="{{ route('topics.store') }}" method="POST">
        @csrf

        <div class="form-group">

            <label for="title">
                お題
            </label>

            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title') }}"
                placeholder="例：こんな学校は嫌だ。どんな学校？"
                required
            >

            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror

        </div>


        <div class="form-group">

    <label for="topic_type">
        お題の種類
    </label>

    <select id="topic_type" name="topic_type" required>

        <option value="">選択してください</option>

        <option value="text" {{ old('topic_type') == 'text' ? 'selected' : '' }}>
            📝 テキスト
        </option>

        <option value="drawing" {{ old('topic_type') == 'drawing' ? 'selected' : '' }}>
            🎨 イラスト
        </option>

        <option value="image" {{ old('topic_type') == 'image' ? 'selected' : '' }}>
            🖼️ 画像
        </option>

    </select>

    @error('topic_type')
        <p class="error">{{ $message }}</p>
    @enderror

</div>


        <div class="buttons">

            <button type="submit" class="submit-button">
                📝 お題を投稿する
            </button>

            <a href="{{ route('topics.index') }}" class="back-button">
                お題一覧に戻る
            </a>

        </div>

    </form>

</div>


<style>

.topic-create-container{
    max-width:800px;
    margin:40px auto;
    padding:40px;
    background:#ffffff;
    border-radius:20px;
    box-shadow:0 8px 25px rgba(0,0,0,0.1);
}

.topic-create-container h1{
    color:#3d0f5e;
    font-size:32px;
    margin-bottom:10px;
}

.description{
    color:#555;
    margin-bottom:30px;
}

.form-group{
    margin-bottom:25px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    color:#3d0f5e;
    font-weight:bold;
}

.form-group input,
.form-group textarea{
    width:100%;
    box-sizing:border-box;
    padding:14px;
    border:2px solid #ddd;
    border-radius:10px;
    font-size:16px;
}

.form-group input:focus,
.form-group textarea:focus{
    outline:none;
    border-color:#ff4f87;
}

.buttons{
    display:flex;
    gap:15px;
    margin-top:30px;
}

.submit-button{
    border:none;
    padding:14px 25px;
    border-radius:10px;
    background:#ff4f87;
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
}

.back-button{
    display:inline-block;
    padding:14px 25px;
    border-radius:10px;
    background:#e8e8e8;
    color:#3d0f5e;
    text-decoration:none;
    font-weight:bold;
}

.submit-button:hover,
.back-button:hover{
    opacity:0.85;
}

.error{
    color:#e53935;
    margin-top:5px;
}

@media(max-width:600px){

    .topic-create-container{
        margin:20px 15px;
        padding:25px 20px;
    }

    .buttons{
        flex-direction:column;
    }

    .submit-button,
    .back-button{
        text-align:center;
    }

}

</style>

@endsection