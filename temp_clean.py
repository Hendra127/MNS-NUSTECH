import os

path = 'routes/web.php'
with open(path, 'rb') as f:
    content = f.read()

# find end of previous route group
target = b"        Route::get('/logs/{siteId}', [MikrotikController::class, 'getCommandLogs'])->name('logs');\r\n    });\r\n});"
idx = content.find(target)
if idx != -1:
    content = content[:idx + len(target)] + b"\r\n\r\nuse App\\Http\\Controllers\\InventoryController;\r\n\r\nRoute::prefix('inventory')->group(function () {\r\n    Route::post('/pengajuan', [InventoryController::class, 'storeSparepart'])->name('inventory.pengajuan.store');\r\n    Route::post('/pengiriman', [InventoryController::class, 'storePengiriman'])->name('inventory.pengiriman.store');\r\n    Route::post('/tracker/{id}/update-repair', [InventoryController::class, 'updateRepairStatus'])->name('inventory.tracker.update-repair');\r\n});\r\n"
    with open(path, 'wb') as f:
        f.write(content)
        
print("Cleaned!")
