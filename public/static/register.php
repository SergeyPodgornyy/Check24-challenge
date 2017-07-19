<?php

require_once __DIR__ . '/inc/helpers.php';

if (isLogedIn()) {
    header('Location: /');
}

$page = 'register';
$action = 'register';

include("inc/header.php");
?>
        <div class="section">
            <div class="wrapper">
                <h2>Register new user</h2>
                <form>
                    <table>
                        <tr>
                            <th>
                                <label for="name">Name</label>
                            </th>
                            <td>
                                <input type="text" id="name" name="name">
                            </td>
                        </tr>
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
                        <tr>
                            <th>
                                <label for="password_repeat">
                                    Repeat Password
                                    <span class="required">(required)</span>
                                </label>
                            </th>
                            <td>
                                <input type="password" id="password_repeat" name="password_repeat">
                            </td>
                        </tr>
                    </table>
                    <?php // TODO: Implement CSRF token protection ?>
                    <input type="submit" value="Register">
                    <p class="text-center">
                        <a href="/login">If you already have an account, you can sign in here</a>
                    </p>
                </form>
            </div>
        </div>

<?php include("inc/footer.php"); ?>