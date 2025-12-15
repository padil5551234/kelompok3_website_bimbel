<!-- WhatsApp Floating Button -->
<div class="whatsapp-float">
    <a href="https://wa.me/{{ config('app.whatsapp_number', '6281234567890') }}?text={{ urlencode(config('app.whatsapp_message', 'Halo, saya ingin berkonsultasi tentang tryout')) }}" 
       target="_blank" 
       class="whatsapp-button"
       title="Konsultasi via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>

<style>
.whatsapp-float {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 9999;
}

.whatsapp-button {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background: #25D366;
    border-radius: 50%;
    color: white;
    font-size: 32px;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
    transition: all 0.3s ease;
    text-decoration: none;
    animation: pulse 2s infinite;
}

.whatsapp-button:hover {
    background: #128C7E;
    color: white;
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
    }
    50% {
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.8);
    }
}

@media (max-width: 768px) {
    .whatsapp-float {
        bottom: 20px;
        right: 20px;
    }
    
    .whatsapp-button {
        width: 50px;
        height: 50px;
        font-size: 28px;
    }
}
</style>