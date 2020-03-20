<!doctype html>
<html class="no-js" lang="pt-BR">
<head>
<title>{{ config('app.name', 'Laravel') }}</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#000000">

  <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <header></header>

    <section class="preloader active">
      <p class="loading">
        <i class="icon"></i>
        <span>
            Carregando...
        </span>
      </p>
    </section>

    <div class="content">

        <section class="home">

          <form action="">
            <h2 class="subtitle">
              Chegou a hora de abrir o coração:
            </h2>

            <div class="input-wrapper">
              <label for="" class="input-container textarea">
                <textarea name="conquista" id="conquista"></textarea>
              </label>
            </div>

            <div class="photo">
              <!-- Mobile upload -->
              <div class="upload-files camera-container">
                <div class="open-camera">
                  <div class="img-background output" style="background-image: url('//:0')"></div>
        
                  <div class="no-image">
                    <img src="{{ asset('images/icons/camera.svg') }}" alt="">
                  </div>
                </div>
              </div>

              <!-- Desktop upload -->
              <div class="upload-files upload">
                <div class="crop-container">
                  <div class="main-cropper"></div>
                  <a class="button action-upload">
                    <input type="file" id="upload" value="Choose Image" accept="image/*">
                    <img src="{{ asset('images/icons/camera.svg') }}" alt="Camera upload">
                  </a>
                </div>
              </div>
            </div>

            <div class="quase-la">
              <div class="input-container-check">
                <input type="checkbox" name="share" id="share">
                <label for="share">
                  Permito que esta foto seja compartilhada em redes sociais
                </label>
              </div>
            </div>

            <button id="enviar" class="enviar">
              Enviar
            </button>
          </form>
        </section>

        <section class="mosaico">
          <p class="loader active">
              <i class="icon"></i>
              <span>
                  Carregando...
              </span>
          </p>

          <canvas class="mosaico-output"></canvas>
        </section>

      </div>
    </div>

  <footer></footer>

  <main class="upload-files camera">
    <canvas class="camera--sensor"></canvas>
    <video class="camera--view" autoplay playsinline></video>
    <div class="camera--trigger-container">
        <button class="camera--trigger"></button>
        <img src="//:0" alt="" class="camera--output">
    </div>
  </main>

  <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
