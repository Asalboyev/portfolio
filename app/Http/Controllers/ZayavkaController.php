<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zayavka;

/**
 * @OA\PathItem(path="/api/zayavkas")
 */
class ZayavkaController extends Controller
{

    /**
     * @OA\Post(
     *      path="/api/zayavka",
     *      summary="Create a new zayavka",
     *      tags={"Zayavka"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Zayavka")
     *      ),
     *      @OA\Response(response="201", description="Created"),
     *  )
     */
    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            // Add other validation rules as needed
        ]);

        $zayavka = Zayavka::create($request->all());

        // Call the function to send the message to Telegram
        $this->sendMessageToTelegram($zayavka, 'order'); // You can pass 'order' or 'one_click' depending on your use case

        return response()->json($zayavka, 201);
    }

    public function sendMessageToTelegram($zayavka, $type)
    {
        // dd($zayavka); // Ushbu qatorni olib tashlang yoki komentariyaga oling

        $botToken = config('telegram.BOT_TOKEN');
        $chatId = config('telegram.TELEGRAM_CHAT_ID');
        $baseUrl = 'https://api.telegram.org/bot';

        if ($type == 'order') {
            $typeText = '🛵Онлайн заказ';
            $text = '%23OnlineOrder'.PHP_EOL.$typeText.' №'.$zayavka->id.PHP_EOL.PHP_EOL.
                '<b>ФИО: </b>'.$zayavka->first_name.' '.$zayavka->last_name.';'.PHP_EOL.
                '<b>Номер телефона:</b> '.$zayavka->phone_number.';'.PHP_EOL.PHP_EOL.
                date('H:i d.m.Y');
        }

        if ($type == 'one_click') {
            $typeText = '🎯<u>Купить в один клик</u>';
            $text = '%23OneClick'.PHP_EOL.$typeText.' №'.$zayavka->id.PHP_EOL.PHP_EOL.
                '<b>ФИО: </b>'.$zayavka->first_name.' '.$zayavka->last_name.';'.PHP_EOL.
                '<b>Номер телефона:</b> '.$zayavka->phone_number.';'.PHP_EOL.PHP_EOL.
                date('H:i d.m.Y');
        }

        Http::get($baseUrl.$botToken.'/sendMessage?chat_id='.$chatId.'&text='.urlencode($text).'&parse_mode=HTML');
    }
    public function show($id)
    {
        return Zayavka::find($id);
    }

    public function update(Request $request, $id)
    {
        $zayavka = Zayavka::findOrFail($id);
        $zayavka->update($request->all());

        return $zayavka;
    }

    public function destroy($id)
    {
        Zayavka::destroy($id);

        return response()->noContent();
    }


//    public function show($id)
//    {
//        $team = Zayavka::find($id);
//
//        if (is_null($team)) {
//            return response()->json(['message' => 'Review not found'], 404);
//        }
//
//        return response()->json($team);
//    }


}
