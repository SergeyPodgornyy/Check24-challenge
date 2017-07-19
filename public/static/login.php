<?php

require_once __DIR__ . '/inc/helpers.php';

if (isLogedIn()) {
    header('Location: /');
}

$page = 'login';
$action = 'login';

include("inc/header.php");

?>
        <div class="section catalog random">
            <div class="wrapper">
                <h2><?= gettext('You need to login') ?></h2>
                <form>
                    <table>
                        <tr>
                            <th>
                                <label for="email">
                                    Email
                                    <span class="required">(required)</span>
                                </label>
                            </th>
                            <td>
                                <input type="text" id="email" name="email">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="password">
                                    Password
                                    <span class="required">(required)</span>
                                </label>
                            </th>
                            <td>
                                <input type="password" id="password" name="password">
                            </td>
                        </tr>
                    </table>
                    <?php // TODO: Implement CSRF token protection ?>
                    <input type="submit" value="Log In">
                    <p class="text-center">
                        <a href="/register">Not registered yet? You can register now for FREE</a>
                    </p>
                </form>
            </div>
        </div>

<?php include("inc/footer.php"); ?>