document.addEventListener('DOMContentLoaded', function() {
    // Image preview for dream submission
    const imageUpload = document.getElementById('dreamImage');
    const imagePreview = document.getElementById('imagePreview');
    
    if (imageUpload && imagePreview) {
        imageUpload.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.addEventListener('load', function() {
                    imagePreview.style.display = 'block';
                    imagePreview.src = this.result;
                });
                
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Form validation for dream submission
    const dreamForm = document.getElementById('dreamForm');
    
    if (dreamForm) {
        dreamForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validate name
            const nameInput = document.getElementById('fullName');
            if (!nameInput.value.trim()) {
                showValidationError(nameInput, 'الرجاء إدخال الاسم الكامل');
                isValid = false;
            } else {
                clearValidationError(nameInput);
            }
            
            // Validate description
            const descInput = document.getElementById('dreamDescription');
            if (!descInput.value.trim()) {
                showValidationError(descInput, 'الرجاء إدخال وصف للحلم');
                isValid = false;
            } else {
                clearValidationError(descInput);
            }
            
            // Validate amount
            const amountInput = document.getElementById('dreamAmount');
            if (!amountInput.value.trim()) {
                showValidationError(amountInput, 'الرجاء إدخال المبلغ');
                isValid = false;
            } else if (isNaN(amountInput.value) || parseInt(amountInput.value) <= 0) {
                showValidationError(amountInput, 'الرجاء إدخال مبلغ صحيح');
                isValid = false;
            } else {
                clearValidationError(amountInput);
            }
            
            // Validate image file type and size
            if (imageUpload && imageUpload.files.length > 0) {
                const file = imageUpload.files[0];
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                const maxFileSize = 1 * 1024 * 1024; // 1MB
                
                if (!validTypes.includes(file.type)) {
                    showValidationError(imageUpload, 'الرجاء اختيار صورة بصيغة مدعومة (JPG, PNG) فقط');
                    isValid = false;
                } else if (file.size > maxFileSize) {
                    showValidationError(imageUpload, 'يجب أن لا يتجاوز حجم الصورة 1 ميجابايت');
                    isValid = false;
                } else {
                    clearValidationError(imageUpload);
                }
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    // Form validation for admin login
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validate username
            const usernameInput = document.getElementById('username');
            if (!usernameInput.value.trim()) {
                showValidationError(usernameInput, 'الرجاء إدخال اسم المستخدم');
                isValid = false;
            } else {
                clearValidationError(usernameInput);
            }
            
            // Validate password
            const passwordInput = document.getElementById('password');
            if (!passwordInput.value) {
                showValidationError(passwordInput, 'الرجاء إدخال كلمة المرور');
                isValid = false;
            } else {
                clearValidationError(passwordInput);
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    // Admin random dream criteria form
    const randomCriteriaForm = document.getElementById('randomCriteriaForm');
    
    if (randomCriteriaForm) {
        randomCriteriaForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validate min amount
            const minAmountInput = document.getElementById('minAmount');
            if (minAmountInput.value && (isNaN(minAmountInput.value) || parseInt(minAmountInput.value) < 0)) {
                showValidationError(minAmountInput, 'الرجاء إدخال مبلغ صحيح');
                isValid = false;
            } else {
                clearValidationError(minAmountInput);
            }
            
            // Validate max amount
            const maxAmountInput = document.getElementById('maxAmount');
            if (maxAmountInput.value && (isNaN(maxAmountInput.value) || parseInt(maxAmountInput.value) <= 0)) {
                showValidationError(maxAmountInput, 'الرجاء إدخال مبلغ صحيح');
                isValid = false;
            } else {
                clearValidationError(maxAmountInput);
            }
            
            // Check if min amount is greater than max amount
            if (isValid && minAmountInput.value && maxAmountInput.value) {
                const minAmount = parseInt(minAmountInput.value);
                const maxAmount = parseInt(maxAmountInput.value);
                
                if (minAmount > maxAmount) {
                    showValidationError(maxAmountInput, 'يجب أن يكون الحد الأقصى أكبر من الحد الأدنى');
                    isValid = false;
                }
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    // Delete dream confirmation
    const deleteButtons = document.querySelectorAll('.delete-dream');
    
    if (deleteButtons.length > 0) {
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                if (!confirm('هل أنت متأكد من حذف هذا الحلم؟')) {
                    e.preventDefault();
                }
            });
        });
    }
    
    // Fulfill dream confirmation
    const fulfillButtons = document.querySelectorAll('.confirm-fulfill');
    
    if (fulfillButtons.length > 0) {
        fulfillButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                if (!confirm('هل أنت متأكد من تحقيق هذا الحلم؟')) {
                    e.preventDefault();
                }
            });
        });
    }
    
    // Functions for validation error handling
    function showValidationError(input, message) {
        // Remove any existing error message
        clearValidationError(input);
        
        // Add invalid class to input
        input.classList.add('is-invalid');
        
        // Create error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        
        // Insert error message after input
        input.parentNode.appendChild(errorDiv);
    }
    
    function clearValidationError(input) {
        input.classList.remove('is-invalid');
        
        // Remove any existing error message
        const errorDiv = input.parentNode.querySelector('.invalid-feedback');
        if (errorDiv) {
            errorDiv.remove();
        }
    }
    
    // New ticker for fulfilled dreams - right to left scrolling without cloning
    function setupNewTicker() {
        const tickerTrack = document.querySelector('.ticker-track');
        if (!tickerTrack || tickerTrack.children.length === 0) return;
        
        // Remove any previously cloned items
        const originalItems = tickerTrack.querySelectorAll('.ticker-item');
        const originalCount = originalItems.length;
        
        // Keep only the original items, remove any clones
        while (tickerTrack.children.length > originalCount) {
            tickerTrack.removeChild(tickerTrack.lastChild);
        }
        
        // Calculate appropriate duration based on content length and viewport
        const contentWidth = tickerTrack.scrollWidth;
        const viewportWidth = window.innerWidth;
        
        // Adjust the speed based on content amount
        let duration = contentWidth / 50; // px per second
        
        // Set minimum duration to prevent too fast movement
        duration = Math.max(duration, 20);
        
        // Apply animation duration
        tickerTrack.style.animationDuration = `${duration}s`;
        
        // Add infinite looping effect with CSS animation
        tickerTrack.style.animationName = 'ticker-slide';
        tickerTrack.style.animationTimingFunction = 'linear';
        tickerTrack.style.animationIterationCount = 'infinite';
        
        // Pause animation on hover
        const tickerContainer = document.querySelector('.ticker-container');
        if (tickerContainer) {
            tickerContainer.addEventListener('mouseenter', function() {
                tickerTrack.style.animationPlayState = 'paused';
            });
            
            tickerContainer.addEventListener('mouseleave', function() {
                tickerTrack.style.animationPlayState = 'running';
            });
        }
    }
    
    // Initialize the new ticker
    setupNewTicker();
    
    // Update ticker when window is resized
    window.addEventListener('resize', setupNewTicker);
});
