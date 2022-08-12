<x-layout>
    <h2>Upload Spreadsheet</h2>
    <form
      action="lexemes/create"
      method="POST"
      enctype="multipart/form-data"
    >
    @csrf
      <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
      <input type="file" id="fileIn" name="fileIn" />
      <button type="submit">Upload File</button>
    </form>
</x-layout>