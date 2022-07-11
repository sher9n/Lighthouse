import { GetStaticProps, InferGetStaticPropsType } from "next";
import { createSwaggerSpec } from "next-swagger-doc";
import dynamic, { DynamicOptions, Loader } from "next/dynamic";
import "swagger-ui-react/swagger-ui.css";

const SwaggerUI = dynamic<{
  spec: Record<string, any>;
}>(import("swagger-ui-react"), { ssr: false });

function ApiDoc({ spec }: InferGetStaticPropsType<typeof getStaticProps>) {
  return <SwaggerUI spec={spec} />;
}

export const getStaticProps: GetStaticProps = async () => {
  const spec: Record<string, any> = createSwaggerSpec({
    apiFolder: "pages/api",
    definition: {
      openapi: "3.0.0",
      info: {
        title: "Lighthouse Solana API",
        version: "1.0",
        description: "API to interact with the Solana Lighthouse program",
      },
    },
  });

  return {
    props: {
      spec,
    },
  };
};

export default ApiDoc;
