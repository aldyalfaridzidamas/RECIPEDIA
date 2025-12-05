<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $recipe->title }}</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .meta {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .recipe-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .content {
            white-space: pre-line;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $recipe->title }}</div>
        <div class="meta">Oleh: {{ $recipe->user->name }} | Dibuat pada: {{ $recipe->created_at->format('d M Y') }}</div>
    </div>

    @if($recipe->image_path)
        <div class="image-container">
            <img src="{{ public_path('storage/' . $recipe->image_path) }}" class="recipe-image" alt="{{ $recipe->title }}">
        </div>
    @endif

    <div class="section">
        <div class="section-title">Deskripsi</div>
        <div class="content">{{ $recipe->description }}</div>
    </div>

    <div class="section">
        <div class="section-title">Bahan-bahan</div>
        <div class="content">{{ $recipe->ingredients }}</div>
    </div>

    <div class="section">
        <div class="section-title">Cara Membuat</div>
        <div class="content">{{ $recipe->instructions }}</div>
    </div>
</body>
</html>
