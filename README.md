# Reading Time PHP Calculator

`EstimatedReadingTime` is a lightweight PHP utility that calculates the estimated reading time (in minutes) for a given block of HTML or plain text content.

It uses a simple heuristic: an average reading speed of **120 words per minute**. It strips HTML tags from the content before counting the words and rounds the result to the nearest full minute (rounding up if the leftover seconds exceed 30 seconds).

## ✅ Features

* Automatically strips HTML tags before processing
* Calculates reading time based on word count
* Easy to update the content dynamically

---

## 🔖 Installation

```bash
composer require midesweb/reading-time
```

## 🧱 Example

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

## 🧪 How it works

1. Strips HTML tags from the input.
2. Counts words using `str_word_count()`.
3. Divides by 120 (average words per minute).
4. Rounds up the result if more than 30 seconds remain.

---

## 💡 Requirements

* PHP **8.0 or higher**

