@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto h-[calc(100vh-140px)] flex flex-col relative overflow-hidden bg-white rounded-[32px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
    
    <!-- Top Header Bar -->
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white z-20">
        <div class="flex items-center gap-4">
            <div class="relative">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center border-2 border-white shadow-sm overflow-hidden">
                    @if($isPatient)
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($sesi->profilKonselor->nama ?? 'Konselor') }}&background=A881C2&color=fff&size=100" alt="Konselor Avatar" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($sesi->user->nama_asli ?? 'Pasien') }}&background=A881C2&color=fff&size=100" alt="Pasien Avatar" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full shadow-sm"></div>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 text-lg leading-tight">
                    @if($isPatient)
                        {{ $sesi->profilKonselor->nama ?? 'Konselor' }}
                    @else
                        {{ $sesi->user->nama_asli ?? 'Pasien' }}
                    @endif
                </h3>
                <p class="text-xs font-semibold text-[#A881C2] tracking-wide uppercase mt-0.5">
                    Live Session &bull; {{ ucfirst(str_replace('_', ' ', $sesi->media_konseling)) }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
                <!-- Tombol Lihat Jurnal (PBI #58) -->
                @if($sesi->journals && $sesi->journals->count() > 0)
                    <button onclick="document.getElementById('journal-modal').classList.remove('hidden')" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Lihat Jurnal ({{ $sesi->journals->count() }})
                    </button>
                @else
                    <button disabled class="bg-gray-50 text-gray-400 cursor-not-allowed px-5 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2">
                        <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Tidak Ada Jurnal
                    </button>
                @endif
                <a href="{{ route($isPatient ? 'history.index' : 'konselor.jadwal') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-sm">
                    Keluar
                </a>
            </div>
        </div>

        <!-- Main Content Area based on Media -->
        <div class="flex-1 bg-gray-50/50 relative flex flex-col w-full h-full">
            
            @if(in_array($sesi->media_konseling, ['video_call', 'voice_call']))
                <!-- JITSI MEET INTEGRATION -->
                <div id="jitsi-container" class="w-full h-full flex-1"></div>
                
                <script src="https://meet.jit.si/external_api.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const domain = 'meet.jit.si';
                        const roomName = 'MindFlowSesiKonseling_{{ $sesi->sesi_konseling_id }}_{{ md5($sesi->created_at) }}';
                        const options = {
                            roomName: roomName,
                            width: '100%',
                            height: '100%',
                            parentNode: document.querySelector('#jitsi-container'),
                            userInfo: {
                                displayName: '{{ $isPatient ? ($sesi->user->nama_samaran ?? $sesi->user->nama_asli) : ($sesi->profilKonselor->nama) }}'
                            },
                            configOverwrite: {
                                startWithAudioMuted: false,
                                startWithVideoMuted: {{ $sesi->media_konseling === 'voice_call' ? 'true' : 'false' }},
                                prejoinPageEnabled: false,
                            },
                            interfaceConfigOverwrite: {
                                // Sembunyikan beberapa fitur jitsi agar terlihat lebih bersih
                                SHOW_JITSI_WATERMARK: false,
                                SHOW_WATERMARK_FOR_GUESTS: false,
                                DEFAULT_BACKGROUND: '#f9fafb',
                                TOOLBAR_BUTTONS: [
                                    'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                                    'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
                                    'livestreaming', 'etherpad', 'sharedvideo', 'settings', 'raisehand',
                                    'videoquality', 'filmstrip', 'invite', 'feedback', 'stats', 'shortcuts',
                                    'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone',
                                    'e2ee'
                                ],
                            }
                        };
                        const api = new JitsiMeetExternalAPI(domain, options);
                    });
                </script>

            @else
                <!-- CHAT UI INTEGRATION -->
                <div class="flex-1 flex flex-col bg-[#F3F4F6] relative overflow-hidden h-full">
                    <!-- Chat Messages Area -->
                    <div id="chat-box" class="flex-1 overflow-y-auto p-6 space-y-6 flex flex-col">
                        <div class="flex justify-center mb-4">
                            <div class="bg-black/5 text-gray-500 text-xs font-semibold px-4 py-1.5 rounded-full uppercase tracking-wider">
                                Sesi Chat Dimulai
                            </div>
                        </div>
                        <!-- Messages will be injected here via JS -->
                    </div>

                    <!-- Chat Input Area -->
                    <div class="bg-white border-t border-gray-100 p-4">
                        <form id="chat-form" class="flex gap-3 items-end">
                            @csrf
                            <textarea id="chat-input" name="isi_pesan" placeholder="Ketik pesan Anda di sini..." rows="1" class="flex-1 bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-4 focus:ring-[#A881C2]/10 focus:border-[#A881C2] text-sm text-gray-700 resize-none" style="min-height: 48px; max-height: 120px;" required></textarea>
                            <button type="submit" id="chat-submit-btn" class="w-12 h-12 flex-shrink-0 bg-[#A881C2] hover:bg-[#8A64A4] text-white rounded-xl flex items-center justify-center transition-colors shadow-lg shadow-purple-200 disabled:opacity-50">
                                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const chatBox = document.getElementById('chat-box');
                        const chatForm = document.getElementById('chat-form');
                        const chatInput = document.getElementById('chat-input');
                        const submitBtn = document.getElementById('chat-submit-btn');
                        let lastMessageCount = 0;
                        
                        const fetchMessages = async () => {
                            try {
                                const res = await fetch("{{ route('konseling.chat.get', $sesi->sesi_konseling_id) }}");
                                const data = await res.json();
                                
                                if(data.messages && data.messages.length > lastMessageCount) {
                                    renderMessages(data.messages, data.current_user_id);
                                    lastMessageCount = data.messages.length;
                                    chatBox.scrollTop = chatBox.scrollHeight;
                                }
                            } catch (err) {
                                console.error("Error fetching chat:", err);
                            }
                        };

                        const renderMessages = (messages, currentUserId) => {
                            // Keep the system message
                            const systemMsg = chatBox.querySelector('.flex.justify-center.mb-4');
                            chatBox.innerHTML = '';
                            if (systemMsg) chatBox.appendChild(systemMsg);

                            messages.forEach(msg => {
                                const isMine = msg.pengirim_id == currentUserId;
                                
                                const div = document.createElement('div');
                                div.className = isMine ? 'flex items-end gap-3 max-w-[80%] ml-auto justify-end' : 'flex items-end gap-3 max-w-[80%]';
                                
                                const avatarHtml = isMine ? '' : `
                                    <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 bg-white shadow-sm">
                                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(msg.nama_pengirim)}&background=A881C2&color=fff&size=50" class="w-full h-full object-cover">
                                    </div>
                                `;

                                const bubbleHtml = isMine ? `
                                    <div class="bg-gradient-to-r from-[#A881C2] to-[#8A64A4] px-5 py-3 rounded-2xl rounded-br-sm shadow-md shadow-purple-200/50 relative">
                                        <p class="text-white text-sm leading-relaxed pr-8 whitespace-pre-wrap">${msg.isi_pesan}</p>
                                        <span class="text-[10px] text-purple-200 absolute bottom-1.5 right-3">${msg.waktu}</span>
                                    </div>
                                ` : `
                                    <div class="bg-white px-5 py-3 rounded-2xl rounded-bl-sm shadow-sm border border-gray-100 relative">
                                        <p class="text-gray-800 text-sm leading-relaxed pr-8 whitespace-pre-wrap">${msg.isi_pesan}</p>
                                        <span class="text-[10px] text-gray-400 absolute bottom-1.5 right-3">${msg.waktu}</span>
                                    </div>
                                `;

                                div.innerHTML = avatarHtml + bubbleHtml;
                                chatBox.appendChild(div);
                            });
                        };

                        chatForm.addEventListener('submit', async (e) => {
                            e.preventDefault();
                            const message = chatInput.value.trim();
                            if(!message) return;

                            submitBtn.disabled = true;
                            chatInput.value = '';

                            try {
                                const res = await fetch("{{ route('konseling.chat.send', $sesi->sesi_konseling_id) }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ isi_pesan: message })
                                });

                                if(res.ok) {
                                    await fetchMessages();
                                }
                            } catch (err) {
                                console.error("Error sending message:", err);
                            } finally {
                                submitBtn.disabled = false;
                                chatInput.focus();
                            }
                        });

                        // Enter to send
                        chatInput.addEventListener('keydown', function(e) {
                            if(e.key === 'Enter' && !e.shiftKey) {
                                e.preventDefault();
                                chatForm.dispatchEvent(new Event('submit'));
                            }
                        });

                        // Poll every 3 seconds
                        setInterval(fetchMessages, 3000);
                        fetchMessages();
                    });
                </script>
            @endif

        </div>
    </div>

    <!-- Modal Lihat Jurnal -->
    @if($sesi->journals && $sesi->journals->count() > 0)
    <div id="journal-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="document.getElementById('journal-modal').classList.add('hidden')"></div>
        
        <!-- Modal Content -->
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden relative z-10 max-h-[85vh] flex flex-col">
            <!-- Header -->
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base">Jurnal Pasien</h3>
                </div>
                <button type="button" onclick="document.getElementById('journal-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-1.5 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-5 overflow-y-auto space-y-4 bg-gray-50 flex-1">
                @foreach($sesi->journals as $journal)
                    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between mb-3 border-b border-gray-50 pb-2">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Tanggal Ditulis</span>
                            <span class="text-[11px] font-bold text-[#A881C2] bg-purple-50 px-2.5 py-1 rounded-md">{{ $journal->created_at->translatedFormat('d M Y, H:i') }}</span>
                        </div>
                        <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-wrap font-medium">{!! trim(strip_tags($journal->content)) !!}</div>
                    </div>
                @endforeach
            </div>
            
            <!-- Footer -->
            <div class="px-5 py-3 border-t border-gray-100 bg-white flex justify-end">
                <button type="button" onclick="document.getElementById('journal-modal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-xl transition-colors">Tutup</button>
            </div>
        </div>
    </div>
    @endif
@endsection
