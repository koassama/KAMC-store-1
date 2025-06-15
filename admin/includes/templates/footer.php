
<!--
 <script>
    DecoupledEditor
        .create( document.querySelector( '#editor' ) )
        .then( editor => {
            const toolbarContainer = document.querySelector( '#toolbar-container' );

            toolbarContainer.appendChild( editor.ui.view.toolbar.element );
        } )
        .catch( error => {
            console.error( error );
        } );
</script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"  crossorigin="anonymous"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"  crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>


<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" ></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" ></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.min.js" ></script>


 </div>


 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-promise/4.2.8/es6-promise.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
 <script type="text/javascript">
 const normalizeArabicText = (text) => text.normalize('NFKD');
 document.getElementById('printpdfpage').innerHTML = normalizeArabicText(document.getElementById('printpdfpage').innerHTML);
 const doc = new jsPDF();
 doc.addFont('Amiri-Regular.ttf', 'Amiri', 'normal');
 doc.setFont('Amiri');
 doc.text('نص عربي مع مسافات', 10, 10, { align: 'right' });
 doc.save('election.pdf');

 </script>
 <script>
   $(document).ready(function () {
     // Get the element to convert to PDF
     var element = document.getElementById('printpdfpage');

     // Set A4 dimensions in points (1 point = 1/72 inch)
     var a4Width = 595.28; // A4 width in points
     var a4Height = 841.89; // A4 height in points

     // Scale factor for better quality (adjust as needed)
     var scaleFactor = 2; // Higher scale improves quality but increases processing time

     // Set PDF options
     var opt = {
       margin: 0, // No margin for full-page PDF
       filename: 'report.pdf', // Name of the output file
       image: { type: 'jpeg', quality: 1 },
       html2canvas: {
         scale: scaleFactor, // Higher scale for better quality
         dpi: 300, // High DPI for sharp output
         letterRendering: true,
         useCORS: true // Enable CORS for cross-origin images
       },
       jsPDF: {
         unit: 'pt', // Use points as the unit
         format: 'a4', // A4 paper size
         orientation: 'portrait' // Portrait orientation (change to 'landscape' if needed)
       }
     };

     // Generate the PDF
     html2pdf()
       .set(opt)
       .from(element)
       .save()
       .then(() => console.log('PDF generated successfully'))
       .catch(error => console.error('PDF generation error:', error));
   });
 </script>
<script type="text/javascript" src="<?php echo $js ?>chartist.js"></script>
 <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"  crossorigin="anonymous"></script> -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
   <!-- <script type="text/javascript" src="<?php echo $js ?>jquery-ui.js"></script> -->

<script type="text/javascript" src="<?php echo $js ?>main.js"></script>
</body>
</html>
