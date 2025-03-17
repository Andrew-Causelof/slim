import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import { resolve } from "path";

export default defineConfig({
  plugins: [react()],
  build: {
    outDir: resolve(__dirname, "dist"), // в dist положит bundle
    rollupOptions: {
      input: resolve(__dirname, "src", "index.jsx"),
      output: {
        entryFileNames: "bundle.js", // Имя итогового файла
        format: "iife", // Самый простой формат для вставки через <script>
      },
    },
  },
});
