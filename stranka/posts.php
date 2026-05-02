<?php
require_once "casti/header.php";
?>

    <main>
        <section class="controls">
            <input id="searchInput" type="text" placeholder="Search blog posts...">
            <div class="filters">
                <button class="filter-btn active" data-category="all">All</button>
                <button class="filter-btn" data-category="study">Study</button>
                <button class="filter-btn" data-category="events">Events</button>
                <button class="filter-btn" data-category="lifestyle">Lifestyle</button>
            </div>
        </section>

        <section class="posts-grid">
            <article class="post-card" data-category="study">
                <img src="../img/sample.png" alt="Sample post image" class="post-image">
                <h3>How to Prepare for a Big Test</h3>
                <p class="meta">Category: Study</p>
                <p>Create a study schedule, review a little each day, and use practice questions to build confidence before exam week.</p>
            </article>

            <article class="post-card" data-category="events">
                <img src="../img/sample.png" alt="Sample post image" class="post-image">
                <h3>Best Moments from School Sports Day</h3>
                <p class="meta">Category: Events</p>
                <p>From relay races to team games, sports day brought students together for a fun and energetic afternoon.</p>
            </article>

            <article class="post-card" data-category="lifestyle">
                <img src="../img/sample.png" alt="Sample post image" class="post-image">
                <h3>Simple Habits for Better Focus</h3>
                <p class="meta">Category: Lifestyle</p>
                <p>Short breaks, daily planning, and limited phone distractions can help students stay focused during the school day.</p>
            </article>

            <article class="post-card" data-category="study">
                <img src="../img/sample.png" alt="Sample post image" class="post-image">
                <h3>Group Projects Without the Stress</h3>
                <p class="meta">Category: Study</p>
                <p>Split tasks clearly, communicate often, and set deadlines early to make teamwork smoother and more productive.</p>
            </article>
        </section>
    </main>

<?php require_once "casti/footer.php"; ?>
