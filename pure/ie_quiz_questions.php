<?php
// IE Quiz Questions System
// This file contains the quiz questions and handles the quiz logic

// Sample quiz questions - you can add more questions here
$questions = array(
    array(
        'question' => 'What is the primary protocol used for block storage in Pure Storage arrays?',
        'options' => array(
            'A' => 'NFS',
            'B' => 'iSCSI',
            'C' => 'SMB',
            'D' => 'HTTP'
        ),
        'correct' => 'B',
        'explanation' => 'iSCSI (Internet Small Computer Systems Interface) is the primary protocol for block storage, along with Fibre Channel.'
    ),
    array(
        'question' => 'What technology does Pure Storage use for data reduction?',
        'options' => array(
            'A' => 'Compression only',
            'B' => 'Deduplication only',
            'C' => 'Both inline deduplication and compression',
            'D' => 'None of the above'
        ),
        'correct' => 'C',
        'explanation' => 'Pure Storage uses both inline deduplication and compression for data reduction, achieving significant space savings.'
    ),
    array(
        'question' => 'What is the minimum number of shelves required in a FlashArray//X configuration?',
        'options' => array(
            'A' => '1 shelf',
            'B' => '2 shelves',
            'C' => '3 shelves',
            'D' => 'No shelves required'
        ),
        'correct' => 'A',
        'explanation' => 'A FlashArray//X can start with a single shelf and scale up as needed.'
    ),
    array(
        'question' => 'What does the Purity Operating Environment run on?',
        'options' => array(
            'A' => 'Windows Server',
            'B' => 'Linux',
            'C' => 'VMware ESXi',
            'D' => 'Custom RTOS'
        ),
        'correct' => 'B',
        'explanation' => 'Purity runs on a hardened Linux kernel, providing stability and security.'
    ),
    array(
        'question' => 'What is SafeMode in Pure Storage?',
        'options' => array(
            'A' => 'A performance monitoring feature',
            'B' => 'A ransomware protection feature',
            'C' => 'A diagnostic mode',
            'D' => 'A maintenance mode'
        ),
        'correct' => 'B',
        'explanation' => 'SafeMode provides immutable snapshots to protect against ransomware attacks and accidental or malicious deletion.'
    )
);

// Get number of questions to display
$num_questions = isset($_GET['num_questions']) ? (int)$_GET['num_questions'] : count($questions);
if ($num_questions > count($questions)) {
    $num_questions = count($questions);
}

// Handle form submission
$show_results = false;
$score = 0;
$answers = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_quiz'])) {
    $show_results = true;
    foreach ($questions as $index => $question) {
        if ($index >= $num_questions) break;
        
        $user_answer = isset($_POST['question_' . $index]) ? $_POST['question_' . $index] : '';
        $answers[$index] = $user_answer;
        
        if ($user_answer == $question['correct']) {
            $score++;
        }
    }
}

?>

<div class="quiz-container" style="padding: 20px;">
    <?php if ($show_results): ?>
        <!-- Show Results -->
        <div class="alert alert-info" style="background: #d9edf7; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
            <h3>Quiz Results</h3>
            <p><strong>Score: <?php echo $score; ?> out of <?php echo $num_questions; ?></strong> 
            (<?php echo round(($score / $num_questions) * 100); ?>%)</p>
            
            <?php if (($score / $num_questions) >= 0.8): ?>
                <p style="color: green;">Excellent work! You have a strong understanding of Pure Storage concepts.</p>
            <?php elseif (($score / $num_questions) >= 0.6): ?>
                <p style="color: orange;">Good job! Review the explanations below to strengthen your knowledge.</p>
            <?php else: ?>
                <p style="color: red;">Keep studying! Review the materials and try again.</p>
            <?php endif; ?>
            
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?num_questions=<?php echo $num_questions; ?>" class="btn btn-primary" style="display: inline-block; padding: 10px 20px; background: #337ab7; color: white; text-decoration: none; border-radius: 4px; margin-top: 10px;">Try Again</a>
        </div>

        <!-- Show correct answers and explanations -->
        <?php foreach (array_slice($questions, 0, $num_questions) as $index => $question): ?>
            <div class="question-review" style="margin-bottom: 30px; padding: 15px; background: #f9f9f9; border-radius: 4px;">
                <h4>Question <?php echo $index + 1; ?>: <?php echo htmlspecialchars($question['question']); ?></h4>
                
                <?php foreach ($question['options'] as $key => $option): ?>
                    <div style="padding: 5px 0;">
                        <?php
                        $class = '';
                        $icon = '';
                        if ($key == $question['correct']) {
                            $class = 'color: green; font-weight: bold;';
                            $icon = '✓ ';
                        } elseif (isset($answers[$index]) && $key == $answers[$index] && $key != $question['correct']) {
                            $class = 'color: red; font-weight: bold;';
                            $icon = '✗ ';
                        }
                        ?>
                        <span style="<?php echo $class; ?>"><?php echo $icon . $key . ') ' . htmlspecialchars($option); ?></span>
                    </div>
                <?php endforeach; ?>
                
                <div style="margin-top: 10px; padding: 10px; background: #e7f4e7; border-left: 4px solid green;">
                    <strong>Explanation:</strong> <?php echo htmlspecialchars($question['explanation']); ?>
                </div>
                
                <?php if (isset($answers[$index])): ?>
                    <div style="margin-top: 10px;">
                        <strong>Your answer:</strong> <?php echo $answers[$index]; ?> 
                        <?php if ($answers[$index] == $question['correct']): ?>
                            <span style="color: green;">✓ Correct</span>
                        <?php else: ?>
                            <span style="color: red;">✗ Incorrect</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <!-- Show Quiz Form -->
        <div class="quiz-intro" style="margin-bottom: 30px;">
            <p><strong>Instructions:</strong> Select the best answer for each question. Click "Submit Quiz" when you're done to see your results.</p>
            <p><strong>Questions:</strong> <?php echo $num_questions; ?> questions selected</p>
        </div>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?num_questions=<?php echo $num_questions; ?>">
            <?php foreach (array_slice($questions, 0, $num_questions) as $index => $question): ?>
                <div class="question-block" style="margin-bottom: 30px; padding: 15px; background: #f9f9f9; border-radius: 4px;">
                    <h4>Question <?php echo $index + 1; ?>:</h4>
                    <p style="font-size: 16px; margin: 10px 0;"><strong><?php echo htmlspecialchars($question['question']); ?></strong></p>
                    
                    <?php foreach ($question['options'] as $key => $option): ?>
                        <div style="padding: 8px 0;">
                            <label style="cursor: pointer;">
                                <input type="radio" name="question_<?php echo $index; ?>" value="<?php echo $key; ?>" required>
                                <span style="margin-left: 8px;"><?php echo $key . ') ' . htmlspecialchars($option); ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <div style="text-align: center; margin: 30px 0;">
                <button type="submit" name="submit_quiz" class="btn btn-primary" style="padding: 15px 40px; font-size: 18px; background: #337ab7; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Submit Quiz
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>

<style>
.quiz-container input[type="radio"] {
    margin-right: 5px;
}
.quiz-container label:hover {
    background: #e8e8e8;
    padding: 5px;
    border-radius: 3px;
}
.btn-primary:hover {
    background: #286090 !important;
}
</style>
