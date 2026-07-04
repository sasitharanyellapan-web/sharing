</main>
</div>
<!-- Footer -->
<footer class="w-full py-section-gap bg-primary">
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter max-w-container-max mx-auto px-margin-mobile">
<div class="col-span-1 md:col-span-2">
<div class="text-headline-md font-headline-md font-bold text-on-primary mb-6">Code Geek Academy</div>
<p class="text-on-primary/80 text-body-md mb-8 max-w-sm">© 2026 Code Geek Academy. Empowering the next generation of innovators with cutting-edge technology curriculum and hands-on mentorship.</p>
</div>
<div>
<h4 class="text-on-primary font-bold mb-6">Quick Links</h4>
<ul class="space-y-4">
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../index.php">Home</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../programs.php">Programs</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../about.php">About</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../contact.php">Contacts</a></li>
</ul>
</div>
<div>
<h4 class="text-on-primary font-bold mb-6">Parent Portal</h4>
<ul class="space-y-4">
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="dashboard.php">Dashboard</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="fees-submission.php">Fee Submission</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="attendance.php">Attendance</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="logout.php">Log Out</a></li>
</ul>
</div>
</div>
</footer>
<script>
        document.querySelectorAll('.glass-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                card.style.setProperty('--mouse-x', `${e.clientX - rect.left}px`);
                card.style.setProperty('--mouse-y', `${e.clientY - rect.top}px`);
            });
        });
    </script>
</body></html>
