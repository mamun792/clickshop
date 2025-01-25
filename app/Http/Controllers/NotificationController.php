<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Repositories\Admin\Report\ReportRepository;
use App\Repositories\Admin\Report\ReportRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    protected $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function fetchUnread(Request $request)
    {
        // Fetch stock-out reports
        $stockOutReports = $this->reportRepository->getOutStockReport();
        // Log::info($stockOutReports);

        if (count($stockOutReports) > 0) {
            foreach ($stockOutReports as $report) {
                // Log::info($report);
                // Check if a notification already exists for this product
                $existingNotification = Notification::where('user_id', Auth::id())
                    ->where('notification_type', 'StockOut')
                    ->where('related_id', $report['id'])
                    ->where('is_read', false)
                    ->first();


                // Log::info($report['id']);
                if (!$existingNotification) {


                Notification::create([
                        'user_id' => Auth::id(),
                        'notification_type' => 'StockOut',
                        'related_id' => $report['id'],
                        'message' => '' . $report['product_name'] .'#'.$report['product_code']. ' <br>This Product is out of stock.',
                        'is_read' => false,
                        'new' => 1,
                    ]);
                }
            }
        }

        $notifications = Notification::orderBy('id', 'desc')->get();

        return response()->json($notifications);
    }



    public function markAsRead($id)
    {
        // Mark the notification as read
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return response()->json(['message' => 'Notification marked as read']);
    }

    public function destroy($id)
    {
        try {
            // Find the notification by ID
            $notification = Notification::findOrFail($id);

            // // Check if the authenticated user owns the notification (optional)
            // if ($notification->user_id !== Auth::id()) {
            //     return response()->json(['message' => 'Unauthorized'], 403);
            // }

            // Delete the notification
            $notification->delete();

            return response()->json(['message' => 'Notification deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting notification', 'error' => $e->getMessage()], 500);
        }
    }
    public function destroylastten() {
        $notifications = Notification::latest()->take(10)->get();
        if ($notifications->isEmpty()) {
            return response()->json(['message' => 'No notifications found'], 404);
        }
        $notifications->each->delete();
        return response()->json(['message' => 'Last 10 notifications deleted successfully']);
    }

}
