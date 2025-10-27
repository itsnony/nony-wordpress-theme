;(() => {
  // Check if device is mobile
  const isMobile =
    /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ||
    window.innerWidth <= 768

  // Only run devtools detection on desktop
  if (!isMobile) {
    // Keystroke detection for devtools shortcuts
    document.addEventListener("keydown", (e) => {
      // F12
      if (e.key === "F12" || e.keyCode === 123) {
        e.preventDefault()
        window.location.href = "https://www.youtube.com/watch?v=dQw4w9WgXcQ"
        return false
      }

      // Ctrl+Shift+I (Windows/Linux) or Cmd+Option+I (Mac)
      if ((e.ctrlKey && e.shiftKey && e.key === "I") || (e.metaKey && e.altKey && e.key === "i")) {
        e.preventDefault()
        window.location.href = "https://www.youtube.com/watch?v=dQw4w9WgXcQ"
        return false
      }

      // Ctrl+Shift+J (Windows/Linux) or Cmd+Option+J (Mac)
      if ((e.ctrlKey && e.shiftKey && e.key === "J") || (e.metaKey && e.altKey && e.key === "j")) {
        e.preventDefault()
        window.location.href = "https://www.youtube.com/watch?v=dQw4w9WgXcQ"
        return false
      }

      // Ctrl+Shift+C (Windows/Linux) or Cmd+Option+C (Mac)
      if ((e.ctrlKey && e.shiftKey && e.key === "C") || (e.metaKey && e.altKey && e.key === "c")) {
        e.preventDefault()
        window.location.href = "https://www.youtube.com/watch?v=dQw4w9WgXcQ"
        return false
      }

      // Ctrl+U (View Source)
      if (e.ctrlKey && e.key === "u") {
        e.preventDefault()
        window.location.href = "https://www.youtube.com/watch?v=dQw4w9WgXcQ"
        return false
      }
    })
  }

  document.addEventListener("DOMContentLoaded", () => {
    const mobileMenuToggle = document.getElementById("mobileMenuToggle")
    const mainNavigation = document.getElementById("mainNavigation")

    if (mobileMenuToggle && mainNavigation) {
      const navMenu = mainNavigation.querySelector("ul")

      mobileMenuToggle.addEventListener("click", function () {
        this.classList.toggle("active")
        if (navMenu) {
          navMenu.classList.toggle("active")
        }
      })

      // Close menu when clicking outside
      document.addEventListener("click", (event) => {
        if (!mobileMenuToggle.contains(event.target) && !mainNavigation.contains(event.target)) {
          mobileMenuToggle.classList.remove("active")
          if (navMenu) {
            navMenu.classList.remove("active")
          }
        }
      })

      // Close menu when clicking a link
      if (navMenu) {
        const navLinks = navMenu.querySelectorAll("a")
        navLinks.forEach((link) => {
          link.addEventListener("click", () => {
            mobileMenuToggle.classList.remove("active")
            navMenu.classList.remove("active")
          })
        })
      }
    }
  })

  // Custom context menu
  const contextMenu = document.getElementById("customContextMenu")

  if (contextMenu) {
    document.addEventListener("contextmenu", (e) => {
      e.preventDefault()
      showCustomMenu(e.pageX, e.pageY)
      return false
    })

    document.querySelectorAll("img").forEach((img) => {
      img.addEventListener("dragstart", (e) => {
        e.preventDefault()
        showCustomMenu(e.pageX, e.pageY)
        return false
      })
    })

    function showCustomMenu(x, y) {
      contextMenu.style.left = x + "px"
      contextMenu.style.top = y + "px"
      contextMenu.classList.add("show")

      setTimeout(() => {
        contextMenu.classList.remove("show")
      }, 2000)
    }

    document.addEventListener("click", () => {
      contextMenu.classList.remove("show")
    })
  }

  // Mouse movement parallax effect
  document.addEventListener("mousemove", (e) => {
    const blobs = document.querySelectorAll(".blob")
    const particles = document.querySelectorAll(".particle")
    const x = e.clientX / window.innerWidth
    const y = e.clientY / window.innerHeight

    blobs.forEach((blob, index) => {
      const speed = (index + 1) * 20
      const xMove = (x - 0.5) * speed
      const yMove = (y - 0.5) * speed
      blob.style.transform = `translate(${xMove}px, ${yMove}px)`
    })

    particles.forEach((particle, index) => {
      const speed = (index + 1) * 15
      const xMove = (x - 0.5) * speed
      const yMove = (y - 0.5) * speed
      particle.style.transform = `translate(${xMove}px, ${yMove}px)`
    })
  })
})()
