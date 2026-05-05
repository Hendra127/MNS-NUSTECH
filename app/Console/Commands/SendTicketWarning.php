<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;
use App\Models\CeContact;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SendTicketWarning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:send-warning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send WhatsApp warning to CE for tickets open more than 3 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tickets = Ticket::where('status', 'open')->get();
        $overdueTickets = [];

        foreach ($tickets as $ticket) {
            $tanggalRekap = Carbon::parse($ticket->tanggal_rekap)->startOfDay();
            $durasi = $tanggalRekap->diffInDays(now()->startOfDay());

            if ($durasi > 3) {
                $ceName = $ticket->ce ?: 'Unknown';
                $overdueTickets[$ceName][] = [
                    'nama_site' => $ticket->nama_site,
                    'site_code' => $ticket->site_code,
                    'durasi' => floor($durasi)
                ];
            }
        }

        if (empty($overdueTickets)) {
            $this->info('No overdue tickets found.');
            return;
        }

        $token = 'buXU17NvXSC7sktQvfVt';

        foreach ($overdueTickets as $ceName => $sites) {
            $contact = CeContact::where('name', $ceName)->first();
            if (!$contact) {
                $this->warn("No phone number found for CE: $ceName");
                continue;
            }

            $message = "*WARNING ⚠️*\n\n";
            $message .= "Halo *" . $ceName . "*,\n";
            $message .= "Berikut adalah daftar site yang *OPEN* Tiket selama *Lebih dari 3 hari* dan perlu di *Follow Up Kembali*:\n\n";

            foreach ($sites as $index => $site) {
                $message .= ($index + 1) . ". *" . $site['nama_site'] . "* - Durasi Open Ticket: *" . $site['durasi'] . " Hari*\n";
            }

            $message .= "\nMohon segera ditindaklanjuti. Terima kasih.";

            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->asForm()->post('https://api.fonnte.com/send', [
                        'target' => $contact->phone,
                        'message' => $message,
                        'countryCode' => '62',
                    ]);

            if ($response->successful()) {
                $this->info("Message sent to $ceName ($contact->phone)");
            } else {
                $this->error("Failed to send message to $ceName. Error: " . $response->body());
            }
        }
    }
}
