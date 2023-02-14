<form method="post">
    <input type="text" name="prompt" id="prompt" placeholder="Enter what you need to asked" Required>
    <input type="submit" value="Submit">
</form>

<?php
if (isset($_POST['prompt'])) {

    $api_key = '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';

    $engine_id = 'text-davinci-003';

    $text = $_POST['prompt'];

    $url = 'https://api.openai.com/v1/engines/' . $engine_id . '/completions';

    $data = array(
        'prompt' => $text,
        'max_tokens' => 300,
        'n' => 1,
        'temperature' => 0.5,
    );

    $data_string = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key,
    ));

    $result = curl_exec($ch);
    $result = json_decode($result);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        
        $msg = $result->choices;
        
        ?>
            <textarea name="massage_result" id="massage_result" cols="150" rows="100">
                <?php echo $msg[0]->text; ?>
            </textarea>
        <?php
        }
    curl_close($ch);
}
?>