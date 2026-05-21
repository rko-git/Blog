<?php
require_once "../php/Blog.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!Auth::isAdmin()) {
    Utility::redirect("home.php");
}
require_once "casti/header.php";
?>

    <main class="admin-page">
        <section class="admin-section">
            <div class="admin-section-header">
                <h2>Categories</h2>
                <button type="button" class="submit-btn">Create category</button>
            </div>
            <div class="admin-list">
                <article class="admin-row">
                    <div class="admin-row-info">
                        <h3>Study</h3>
                        <p class="meta">ID: 1 · Slug: study</p>
                    </div>
                    <div class="admin-actions">
                        <button type="button" class="admin-btn admin-btn-edit">Edit</button>
                        <button type="button" class="admin-btn admin-btn-delete">Delete</button>
                    </div>
                </article>
            </div>
        </section>

        <section class="admin-section">
            <div class="admin-section-header">
                <h2>Posts</h2>
            </div>
            <div class="admin-list">
                <article class="admin-row">
                    <div class="admin-row-info">
                        <h3>How to Prepare for a Big Test</h3>
                        <p class="meta">ID: 1 · Category: Study · Author: admin</p>
                        <p>Create a study schedule, review a little each day, and use practice questions before exam week.</p>
                    </div>
                    <div class="admin-actions">
                        <button type="button" class="admin-btn admin-btn-edit">Edit</button>
                        <button type="button" class="admin-btn admin-btn-delete">Delete</button>
                    </div>
                </article>
            </div>
        </section>

        <section class="admin-section">
            <div class="admin-section-header">
                <h2>Registered users</h2>
            </div>
            <div class="admin-list">
                <article class="admin-row">
                    <div class="admin-row-info">
                        <h3>admin</h3>
                        <p class="meta">ID: 1 · admin@admin.net · Role: Admin</p>
                    </div>
                    <div class="admin-actions">
                        <button type="button" class="admin-btn admin-btn-edit">Edit</button>
                        <button type="button" class="admin-btn admin-btn-delete">Delete</button>
                    </div>
                </article>
            </div>
        </section>
    </main>

<?php require_once "casti/footer.php"; ?>
