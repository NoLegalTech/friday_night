<?php

    /*
     * Lista Viernes, a tool to create a secured data base of citizens to publicly
     * state rejection to use their data for political campaigns.
     *
     * Copyright (C) 2019  NoLegalTech
     *
     *    This program is free software; you can redistribute it and/or modify
     *    it under the terms of the GNU General Public License as published by
     *    the Free Software Foundation; either version 3 of the License, or
     *    (at your option) any later version.
     *
     *    This program is distributed in the hope that it will be useful,
     *    but WITHOUT ANY WARRANTY; without even the implied warranty of
     *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *    GNU General Public License for more detai
     *
     *    You should have received a copy of the GNU General Public License
     *    along with this program; if not, write to the Free Software Foundation,
     *    Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301
     *
     */

    require_once(__DIR__.'/inc/functions.php');

    page_open();

?>

    <section class="post">
        <header>
            <h2>Error</h2>
        </header>
        <p>
            <?php
                if (isset($_SESSION['error'])) {
                    echo $_SESSION['error'];
                } else {
                    echo 'Error inesperado.';
                }
            ?>
        </p>
    </section>

<?php
    unset($_SESSION['error']);

    page_close();
?>
