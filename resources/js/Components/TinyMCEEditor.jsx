import { useRef } from "react";
import { Editor } from "@tinymce/tinymce-react";

export default function TinyMCEEditor({ value, onChange, height = 500 }) {
    const editorRef = useRef(null);

    const handleEditorChange = (content, editor) => {
        if (onChange) {
            onChange(content);
        }
    };

    return (
        <Editor
            apiKey="syp4wninflmguatyzvxjwy8nk844tqhljwwatk3gw8dl977t" // Using free version without API key
            onInit={(evt, editor) => (editorRef.current = editor)}
            value={value}
            onEditorChange={handleEditorChange}
            init={{
                height: height,
                menubar: true,
                plugins: [
                    "advlist",
                    "autolink",
                    "lists",
                    "link",
                    "image",
                    "charmap",
                    "preview",
                    "anchor",
                    "searchreplace",
                    "visualblocks",
                    "code",
                    "fullscreen",
                    "insertdatetime",
                    "media",
                    "table",
                    "code",
                    "help",
                    "wordcount",
                ],
                toolbar:
                    "undo redo | blocks | " +
                    "bold italic forecolor backcolor | alignleft aligncenter " +
                    "alignright alignjustify | bullist numlist outdent indent | " +
                    "removeformat | image link media | code | help",
                content_style:
                    "body { font-family:Helvetica,Arial,sans-serif; font-size:14px }",

                // Image upload handler
                images_upload_handler: async (blobInfo, progress) => {
                    return new Promise(async (resolve, reject) => {
                        const formData = new FormData();
                        formData.append(
                            "file",
                            blobInfo.blob(),
                            blobInfo.filename()
                        );
                        formData.append("title", blobInfo.filename());
                        formData.append("alt_text", blobInfo.filename());

                        try {
                            const response = await fetch("/admin/media", {
                                method: "POST",
                                body: formData,
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]'
                                    ).content,
                                    Accept: "application/json",
                                },
                                credentials: "same-origin",
                            });

                            const result = await response.json();

                            if (response.ok && result.media) {
                                // Return the URL of uploaded image
                                resolve("/storage/" + result.media.file_path);
                            } else {
                                reject("Image upload failed");
                            }
                        } catch (error) {
                            reject("Image upload failed: " + error.message);
                        }
                    });
                },

                // Allow all image formats
                images_file_types: "jpg,jpeg,png,gif,webp,svg",

                // Clean paste from Word
                paste_word_valid_elements:
                    "p,b,strong,i,em,h1,h2,h3,h4,h5,h6,ul,ol,li,a,img",

                // SVG, image зэрэг элементүүдийг зөвшөөрөх
                extended_valid_elements:
                    "svg[*],path[*],circle[*],rect[*],line[*],polygon[*],polyline[*],ellipse[*],g[*],defs[*],use[*],symbol[*],title[*],desc[*]",
                valid_children:
                    "+svg[title|desc|path|circle|rect|line|polygon|polyline|ellipse|g|defs|use|symbol]",

                // Invalid elements-ээс svg-г хас
                invalid_elements: "script,style",

                // Хадгалах үед кодыг өөрчлөхгүй байлгах
                verify_html: false,
                cleanup: false,

                // SVG-г paste хийхэд устгахгүй байлгах
                paste_data_images: true,

                // Үлдсэн тохиргоонууд
                automatic_uploads: true,
                // Branding
                branding: false,
                promotion: false,
            }}
        />
    );
}
