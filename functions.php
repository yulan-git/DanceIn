<?php
function dump($variable)
{
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
}

function nav_item(string $lien, string $titre, string $linkClass = ''): string
{
    $classe = '';
    if ($_SERVER['SCRIPT_NAME'] === $lien) {
        $classe .= ' active';
    }
    return <<<HTML
        <a class="$linkClass" href="$lien">$titre</a>
HTML;
}

function nav_menu(string $linkClass = ''): string
{
    return
        nav_item('indexSiteDance.php', 'Accueil <i class="fas fa-home"></i>', $linkClass) .
        nav_item('contact.php', 'Contact <i class="fas fa-info-circle"></i>', $linkClass) .
        nav_item('connexion.php', 'Connexion <i class="fas fa-user"></i>', $linkClass);;
}

function checkbox(string $name, string $value, array $data): string
{
    $attributes = '';
    if (isset($data[$name]) && in_array($value, $data[$name])) {
        $attributes .= 'checked';
    }
    return <<<HTML
    <input type="checkbox" name="{$name}[]" value="$value" $attributes>
HTML;
}

function select(string $name, &$value, array $options): string
{
    $html_options = [];
    foreach ($options as $k => $option) {
        $attributes = $k == $value ? ' selected' : '';
        $html_options[] = "<option value='$k' $attributes>$option</option>";
    }
    return "<select class='form-control' id='$name' name='$name'>" . implode($html_options) . '</select>';
}
