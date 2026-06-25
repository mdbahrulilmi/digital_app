window.imageCropper = function (wireModel, ratio = 1) {
    return {
        cropper: null,
        show: false,

        openCropper(event) {
            console.log('OPEN CROPPER');
            const file = event.target.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = (e) => {

                this.show = true;

                this.$nextTick(() => {

                    this.$refs.image.src = e.target.result;

                    if (this.cropper) {
                        this.cropper.destroy();
                    }

                    this.cropper = new Cropper(this.$refs.image, {
                        aspectRatio: ratio,
                        viewMode: 1,
                    });
                });
            };

            reader.readAsDataURL(file);
        },

        close() {
            this.show = false;

            if (this.cropper) {
                this.cropper.destroy();
                this.cropper = null;
            }
        },

        save() {

            this.cropper
                .getCroppedCanvas({
                    width: 1200,
                    height: 1200
                })
                .toBlob(blob => {

                    let file = new File(
                        [blob],
                        'cropped.webp',
                        { type: 'image/webp' }
                    );

                    Livewire.find(
                        this.$root.closest('[wire\\:id]')
                            .getAttribute('wire:id')
                    ).upload(
                        wireModel,
                        file
                    );

                    this.close();
                }, 'image/webp', 0.9);
        }
    }
}