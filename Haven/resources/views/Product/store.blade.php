<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2>Create Product</h2>
        <form action="{{route('Product.store')}}" enctype="multipart/form-data"  method="post"  >
          @csrf
       
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="weight" class="form-label">Weight</label>
                <input type="number" step="0.01" class="form-control" id="weight" name="weight">
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label for="expiry" class="form-label">Expiry Date</label>
                <input type="date" class="form-control" id="expiry" name="expiry">
            </div>
            <div class="mb-3">
                <label for="preserve" class="form-label">Preserve</label>
                <input type="text" class="form-control" id="preserve" name="preserve">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                <input class="form-control" type="file" id="formFileMultiple" name="image" multiple>
            </div>
              
            {{-- <div class="mb-3">
                <label for="category_id" class="form-label">Category ID</label>
                <input type="number" class="form-control" id="category_id" name="category_id" required>
            </div> --}}
            <label for="category_id" class="form-label">Category ID</label>
            <select class="form-select" name="category_id" aria-label="Default select example">
                @foreach ($categories as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
           
               
              </select>
            {{-- <div class="mb-3">
                <label for="brand_id" class="form-label">Brand ID</label>
                <input type="number" class="form-control" id="brand_id" name="brand_id">
            </div> --}}
            <label for="brand_id" class="form-label">Brand ID</label>
            <select class="form-select" name="brand_id" aria-label="Default select example">
                @foreach ($brands as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
           
               
              </select>
            <div class="mb-3">
                <label for="manufacture" class="form-label">Manufacture</label>
                <input type="text" class="form-control" id="manufacture" name="manufacture">
            </div>
            <div class="mb-3">
                <label for="subtitle" class="form-label">Subtitle</label>
                <input type="text" class="form-control" id="subtitle" name="subtitle">
            </div>
            <div class="mb-3">
                <label for="sale" class="form-label">Sale</label>
                <input type="number" step="0.01" class="form-control" id="sale" name="sale">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>