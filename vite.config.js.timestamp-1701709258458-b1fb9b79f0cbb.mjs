// vite.config.js
import fs from "fs";
import {defineConfig} from "file:///D:/Homestead/simdata-sosial/node_modules/vite/dist/node/index.js";
import laravel from "file:///D:/Homestead/simdata-sosial/node_modules/laravel-vite-plugin/dist/index.mjs";
import {homedir} from "os";
import {resolve} from "path";

var host = "simdata-sosial.local";
var vite_config_default = defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/filament/admin/theme.css"
            ],
            refresh: true
        })
    ],
    server: detectServerConfig(host)
});

function detectServerConfig(host2) {
    let keyPath = resolve(
        homedir(),
        "D:/Development/laragon/etc/ssl/laragon.key"
    );
    let certificatePath = resolve(
        homedir(),
        "D:/Development/laragon/etc/ssl/laragon.crt"
    );
    if (!fs.existsSync(keyPath)) {
        return {};
    }
    if (!fs.existsSync(certificatePath)) {
        return {};
    }
    return {
        hmr: {host: host2},
        host: host2,
        https: {
            key: fs.readFileSync(keyPath),
            cert: fs.readFileSync(certificatePath)
        }
    };
}

export {
    vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJEOlxcXFxIb21lc3RlYWRcXFxcc2ltZGF0YS1zb3NpYWxcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkQ6XFxcXEhvbWVzdGVhZFxcXFxzaW1kYXRhLXNvc2lhbFxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vRDovSG9tZXN0ZWFkL3NpbWRhdGEtc29zaWFsL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IGZzIGZyb20gXCJmc1wiO1xuaW1wb3J0IHtkZWZpbmVDb25maWd9IGZyb20gXCJ2aXRlXCI7XG5pbXBvcnQgbGFyYXZlbCBmcm9tIFwibGFyYXZlbC12aXRlLXBsdWdpblwiO1xuaW1wb3J0IHtob21lZGlyfSBmcm9tIFwib3NcIjtcbmltcG9ydCB7cmVzb2x2ZX0gZnJvbSBcInBhdGhcIjtcblxubGV0IGhvc3QgPSBcInNpbWRhdGEtc29zaWFsLmxvY2FsXCI7XG5cbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gICAgcGx1Z2luczogW1xuICAgICAgICBsYXJhdmVsKHtcbiAgICAgICAgICAgIGlucHV0OiBbXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9jc3MvYXBwLmNzcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9hcHAuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvY3NzL2ZpbGFtZW50L2FkbWluL3RoZW1lLmNzcydcbiAgICAgICAgICAgIF0sXG4gICAgICAgICAgICByZWZyZXNoOiB0cnVlLFxuICAgICAgICB9KSxcbiAgICBdLFxuICAgIHNlcnZlcjogZGV0ZWN0U2VydmVyQ29uZmlnKGhvc3QpLFxufSk7XG5cbmZ1bmN0aW9uIGRldGVjdFNlcnZlckNvbmZpZyhob3N0KSB7XG4gICAgbGV0IGtleVBhdGggPSByZXNvbHZlKFxuICAgICAgICBob21lZGlyKCksXG4gICAgICAgIFwiRDovRGV2ZWxvcG1lbnQvbGFyYWdvbi9ldGMvc3NsL2xhcmFnb24ua2V5XCJcbiAgICApO1xuICAgIGxldCBjZXJ0aWZpY2F0ZVBhdGggPSByZXNvbHZlKFxuICAgICAgICBob21lZGlyKCksXG4gICAgICAgIFwiRDovRGV2ZWxvcG1lbnQvbGFyYWdvbi9ldGMvc3NsL2xhcmFnb24uY3J0XCJcbiAgICApO1xuXG4gICAgaWYgKCFmcy5leGlzdHNTeW5jKGtleVBhdGgpKSB7XG4gICAgICAgIHJldHVybiB7fTtcbiAgICB9XG5cbiAgICBpZiAoIWZzLmV4aXN0c1N5bmMoY2VydGlmaWNhdGVQYXRoKSkge1xuICAgICAgICByZXR1cm4ge307XG4gICAgfVxuXG4gICAgcmV0dXJuIHtcbiAgICAgICAgaG1yOiB7aG9zdH0sXG4gICAgICAgIGhvc3QsXG4gICAgICAgIGh0dHBzOiB7XG4gICAgICAgICAgICBrZXk6IGZzLnJlYWRGaWxlU3luYyhrZXlQYXRoKSxcbiAgICAgICAgICAgIGNlcnQ6IGZzLnJlYWRGaWxlU3luYyhjZXJ0aWZpY2F0ZVBhdGgpLFxuICAgICAgICB9LFxuICAgIH07XG59XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQXlRLE9BQU8sUUFBUTtBQUN4UixTQUFRLG9CQUFtQjtBQUMzQixPQUFPLGFBQWE7QUFDcEIsU0FBUSxlQUFjO0FBQ3RCLFNBQVEsZUFBYztBQUV0QixJQUFJLE9BQU87QUFFWCxJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixTQUFTO0FBQUEsSUFDTCxRQUFRO0FBQUEsTUFDSixPQUFPO0FBQUEsUUFDSDtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsTUFDSjtBQUFBLE1BQ0EsU0FBUztBQUFBLElBQ2IsQ0FBQztBQUFBLEVBQ0w7QUFBQSxFQUNBLFFBQVEsbUJBQW1CLElBQUk7QUFDbkMsQ0FBQztBQUVELFNBQVMsbUJBQW1CQSxPQUFNO0FBQzlCLE1BQUksVUFBVTtBQUFBLElBQ1YsUUFBUTtBQUFBLElBQ1I7QUFBQSxFQUNKO0FBQ0EsTUFBSSxrQkFBa0I7QUFBQSxJQUNsQixRQUFRO0FBQUEsSUFDUjtBQUFBLEVBQ0o7QUFFQSxNQUFJLENBQUMsR0FBRyxXQUFXLE9BQU8sR0FBRztBQUN6QixXQUFPLENBQUM7QUFBQSxFQUNaO0FBRUEsTUFBSSxDQUFDLEdBQUcsV0FBVyxlQUFlLEdBQUc7QUFDakMsV0FBTyxDQUFDO0FBQUEsRUFDWjtBQUVBLFNBQU87QUFBQSxJQUNILEtBQUssRUFBQyxNQUFBQSxNQUFJO0FBQUEsSUFDVixNQUFBQTtBQUFBLElBQ0EsT0FBTztBQUFBLE1BQ0gsS0FBSyxHQUFHLGFBQWEsT0FBTztBQUFBLE1BQzVCLE1BQU0sR0FBRyxhQUFhLGVBQWU7QUFBQSxJQUN6QztBQUFBLEVBQ0o7QUFDSjsiLAogICJuYW1lcyI6IFsiaG9zdCJdCn0K
