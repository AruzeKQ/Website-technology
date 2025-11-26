<?php
// Simple quiz app that reads questions from Quiz.txt and renders a multiple-choice quiz.

function load_quiz($path)
{
    if (!is_readable($path))
        return [];
    $text = file_get_contents($path);
    // Split blocks by blank lines
    $blocks = preg_split('/\r?\n\r?\n+/', trim($text));
    $questions = [];

    foreach ($blocks as $block) {
        $lines = preg_split('/\r?\n/', trim($block));
        $q = ['question' => '', 'options' => [], 'answers' => []];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '')
                continue;
            // ANSWER: line
            if (preg_match('/^ANSWER:\s*(.+)$/i', $line, $m)) {
                $ans = strtoupper(trim($m[1]));
                // split by comma for multi answers
                $parts = preg_split('/\s*,\s*/', $ans);
                $q['answers'] = array_map('trim', $parts);
                continue;
            }
            // Option lines like "A. Text" or "A) Text"
            if (preg_match('/^([A-Z])\s*[\.|\)]\s*(.+)$/i', $line, $m)) {
                $key = strtoupper($m[1]);
                $q['options'][$key] = $m[2];
                continue;
            }
            // First non-option & non-answer line -> question
            if ($q['question'] === '') {
                $q['question'] = $line;
                continue;
            }
            // If we get here, treat as continuation of question
            $q['question'] .= ' ' . $line;
        }
        if ($q['question'] !== '' && count($q['options']) > 0) {
            $questions[] = $q;
        }
    }
    return $questions;
}

$quizFile = __DIR__ . '/Quiz.txt';
$questions = load_quiz($quizFile);
$total = count($questions);
$score = 0;
$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($questions as $i => $q) {
        $qid = 'q' . $i;
        $correct = array_map('strtoupper', array_map('trim', $q['answers']));
        $is_multi = count($correct) > 1;

        if ($is_multi) {
            $selected = isset($_POST[$qid]) && is_array($_POST[$qid]) ? $_POST[$qid] : [];
            $selected = array_map('strtoupper', array_map('trim', $selected));
            sort($selected);
            $expected = $correct;
            sort($expected);
            $ok = ($selected === $expected);
            if ($ok)
                $score++;
            $results[$i] = ['ok' => $ok, 'selected' => $selected, 'expected' => $expected];
        } else {
            $selected = isset($_POST[$qid]) ? strtoupper(trim($_POST[$qid])) : '';
            $ok = in_array($selected, $correct) && $selected !== '';
            if ($ok)
                $score++;
            $results[$i] = ['ok' => $ok, 'selected' => [$selected], 'expected' => $correct];
        }
    }
}

function h($s)
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Quiz từ Quiz.txt</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Quiz trắc nghiệm</h1>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div class="score">Kết quả: <?php echo "$score / $total"; ?></div>
        <?php endif; ?>

        <form method="post">
            <?php foreach ($questions as $i => $q):
                $qid = 'q' . $i;
                $correct = array_map('strtoupper', array_map('trim', $q['answers']));
                $is_multi = count($correct) > 1;
                ?>
                <fieldset class="question">
                    <legend><strong><?php echo ($i + 1) . '. ' . h($q['question']); ?></strong></legend>
                    <div class="options">
                        <?php foreach ($q['options'] as $key => $label):
                            $name = $is_multi ? $qid . '[]' : $qid;
                            $type = $is_multi ? 'checkbox' : 'radio';
                            $inputId = $qid . '_' . $key;
                            $checked = '';
                            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($results[$i])) {
                                $sel = $results[$i]['selected'];
                                if (in_array($key, $sel))
                                    $checked = ' checked';
                            }
                            ?>
                            <label class="option" for="<?php echo h($inputId); ?>">
                                <input type="<?php echo $type; ?>" id="<?php echo h($inputId); ?>"
                                    name="<?php echo h($name); ?>" value="<?php echo h($key); ?>" <?php echo $checked; ?>>
                                <span class="opt-key"><?php echo h($key); ?>.</span>
                                <span class="opt-label"><?php echo h($label); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'):
                        $r = $results[$i];
                        ?>
                        <div class="feedback <?php echo $r['ok'] ? 'correct' : 'wrong'; ?>">
                            <?php if ($r['ok']): ?>
                                Đúng
                            <?php else: ?>
                                Sai. Đáp án đúng: <?php echo h(implode(', ', $r['expected'])); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </fieldset>
            <?php endforeach; ?>

            <?php if ($total === 0): ?>
                <p>Không tìm thấy câu hỏi trong `Quiz.txt`.</p>
            <?php else: ?>
                <div class="actions">
                    <button type="submit">Nộp bài</button>
                    <button type="button" onclick="window.location=window.location">Làm lại</button>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>

</html>