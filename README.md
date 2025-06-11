# Reading Time PHP Calculator

`EstimatedReadingTime` is a lightweight PHP utility that calculates the estimated reading time (in minutes) for a given block of HTML or plain text content.

It uses a simple heuristic: an average reading speed of **120 words per minute**. It strips HTML tags from the content before counting the words and rounds the result to the nearest full minute (rounding up if the leftover seconds exceed 30 seconds).

## ✅ Features

* Automatically strips HTML tags before processing
* Calculates reading time based on word count
* Easy to update the content dynamically
* Supports human-readable output in English (`EN`) and Spanish (`ES`)

---

## 🔖 Installation

```bash
composer require midesweb/reading-time
```

## 🧱 Basic Example

```php
use Midesweb\ReadingTime\EstimatedReadingTime;

$content = "<p>This is a sample article with some <strong>HTML</strong> content.</p>";
$estimator = new EstimatedReadingTime($content);

$minutes = $estimator->getEstimatedReadingMinutes();

echo "Estimated reading time: {$minutes} minute(s)";
```

### 🔁 Updating the content

```php
$estimator->updateContent("New content goes here...");
$minutes = $estimator->getEstimatedReadingMinutes();
```

---

## 🌍 Localized Read Time Output

You can get a localized string describing the estimated read time using `getReadTime()`.  
The default language is English (`EN`), but you can switch to Spanish (`ES`) using `setLanguage()`:

```php
$estimator = new EstimatedReadingTime($content);

// English (default)
echo $estimator->getReadTime(); 
// Output: "1 minute", "3 minutes", "1 hour and 5 minutes", etc.

// Spanish
echo $estimator->setLanguage('es')->getReadTime();
// Output: "1 minuto", "3 minutos", "1 hora y 5 minutos", etc.
```

> 🔒 Only `EN` and `ES` are supported. Invalid languages will throw an `InvalidArgumentException`.

---

## 🧪 How it works

1. Strips HTML tags from the input.
2. Counts words using `str_word_count()`.
3. Divides by 120 (average words per minute).
4. Rounds up the result if more than 30 seconds remain.
5. Optionally returns a localized human-readable string.

---

## 💡 Requirements

* PHP **7.4 or higher**
