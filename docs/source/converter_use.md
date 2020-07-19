## Użycie konwertera

### 1. Instalujemy paczke przez composera:
```text
composer require liderit/pdf-to-gallery-converter "^1.0.2"
```

### 2. Pobieramy plik

```php
$doc = $_FILES["documentFile"];
```

### 3. Określamy gdzie nasze zdjęcia mają trafić

```php
$endDir = __DIR__ . DIRECTORY_SEPARATOR . 'output';
```

### 4. Tworzymy instancje konwertera

```php
use PdfToGallery\PdfToImageConverter;
use PdfToGallery\Exceptions\ConvertPdfFileException;
use PdfToGallery\Exceptions\InvalidPdfFileException;

$converter = new PdfToImageConverter($_ENV);
```

### 5. Konwertujemy

> Konwersja może trochę zająć = 100 stron ~ 4-8 minut

```php
$converter->splitAndConvert($doc, $endDir);
```

> Wynik znajdziemy w bazie danych
