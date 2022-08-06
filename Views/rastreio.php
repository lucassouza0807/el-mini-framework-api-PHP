<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <link href="..8/dist/output.css" rel="stylesheet">
</head>

<body>
    <header class="bg-orange-100 h-[7rem] shadow-md">
        <h1> SISTEMA </h1>
    </header>
    <div class="container p-5 top-[100px] relative bg-white w-[30vw] shadow-l h-[450px] rounded">
        <h1 class="text-[3rem] font-bold">Olá</h1>
        <h2 class="w-[50%] text-[2rem] mb-[30px]">Acompanhe seu pedido!</h2>
        <form class="flex flex-col justify-left" method="post" action="/rastrear-pedido">
            <div class="text-center">
                <div class="text-left mb-[10px]">
                    <label class="relative mb-[40px] text-lg" for="codigo-rastreio">Codigo de rastreio</label>
                </div>
                <input class="w-[100%] pl-[20px] text-lg border-[1px] border-black h-[40px] rounded-lg mb-[30px]" classtype="text" name="codigo-rastreio"> </input>
                <button type="submit" class="bg-indigo-400 text-center w-[60%] text-white h-[40px] items-center rounded-md font-bold"> Acompanhar pedido </button>
            </div>
        </form>
    </div>
</body>

</html>