import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import { resolve } from "path";

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    proxy: {
      "/api": {
        target: "https://spinelife.seo-gravity.ru",
        changeOrigin: true,
        secure: false,
      },
    },
  },
  build: {
    outDir: resolve(__dirname, "dist"),
    rollupOptions: {
      input: resolve(__dirname, "src", "main.jsx"),
      output: {
        entryFileNames: "bundle.js",
        format: "iife",
      },
    },
  },
});
