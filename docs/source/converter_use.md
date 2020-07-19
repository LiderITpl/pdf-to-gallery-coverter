## Użycie konwertera

### 1. Instalujemy paczke przez composera:
```text
composer require liderit/mt940-converter "^1.0.0"
```

### 2. Pobieramy plik

```php
$doc = $_FILES["documentFile"]["tmp_name"];
```

### 3. Pobieramy treść pliku

```php
$content = file_get_contents($doc);
```

### 4. Tworzymy instancje konwertera i importujemy dokument

```php

```

### 5. Obsługujemy wynik
